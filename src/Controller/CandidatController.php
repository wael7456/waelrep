<?php

namespace App\Controller;

use App\Entity\Offre;
use App\Entity\Postulation;
use App\Form\PostulationType;
use App\Repository\OffreRepository;
use App\Repository\PostulationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/candidat')]
class CandidatController extends AbstractController
{
    #[Route('/', name: 'candidat_dashboard')]
public function index(Request $request, OffreRepository $repo, OffreRepository $offreRepository, PostulationRepository $postulationRepository): Response
{
    $user = $this->getUser(); // Déclare l'utilisateur d'abord
    $postulations = $postulationRepository->findBy(['candidat' => $user]);
    $offres = $offreRepository->findAll();
    $search = $request->query->get('q');
    

    if ($search) {
        $offres = $offreRepository->createQueryBuilder('o')
            ->where('LOWER(o.titre) LIKE :search')
            ->setParameter('search', '%' . strtolower($search) . '%')
            ->orderBy('o.dateLimite', 'DESC')
            ->getQuery()
            ->getResult();
    } else {
        $offres = $offreRepository->findBy([], ['dateLimite' => 'DESC']);
    }




    return $this->render('candidat/index.html.twig', [
        'offres' => $offres,
        'postulations' => $postulations,
        'q' => $search,


    ]);
}

#[Route('/candidat/postuler/{id}', name: 'candidat_postuler')]
public function postuler(
    Request $request,
    Offre $offre,
    EntityManagerInterface $em,
    PostulationRepository $postulationRepository,
    SluggerInterface $slugger
): Response {
    $user = $this->getUser(); // utilisateur connecté

    //  Vérifier si ce candidat a déjà postulé à cette offre
    $postulationExistante = $postulationRepository->findOneBy([
        'offre' => $offre,
        'candidat' => $user,
    ]);

    if ($postulationExistante) {
        $this->addFlash('warning', '⚠️ Vous avez déjà postulé à cette offre.');
        return $this->redirectToRoute('candidat_mes_postulations');
    }

    //  Création de la nouvelle postulation
    $postulation = new Postulation();
    $form = $this->createForm(PostulationType::class, $postulation);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $postulation->setCandidat($user);
        $postulation->setOffre($offre);
        $postulation->setStatut('En attente');
        $postulation->setDatePostulation(new \DateTime());

        //  Upload CV
        $cvFile = $form->get('CV')->getData();
        if ($cvFile) {
            $originalFilename = pathinfo($cvFile->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = $slugger->slug($originalFilename);
            $newFilename = $safeFilename . '-' . uniqid() . '.' . $cvFile->guessExtension();

            $cvFile->move(
                $this->getParameter('cv_directory'),
                $newFilename
            );

            $postulation->setCV($newFilename);
        }

        $em->persist($postulation);
        $em->flush();

        $this->addFlash('success', '✅ Votre candidature a été enregistrée !');
        return $this->redirectToRoute('candidat_dashboard');
    }

    return $this->render('candidat/postuler.html.twig', [
        'form' => $form->createView(),
        'offre' => $offre,
    ]);
}


    #[Route('/mes-postulations', name: 'candidat_mes_postulations')]
    public function mesPostulations(PostulationRepository $postulationRepository): Response
    {
        $user = $this->getUser();
        $postulations = $postulationRepository->findBy(['candidat' => $user]);

        return $this->render('candidat/mes_postulations.html.twig', [
            'postulations' => $postulations,
        ]);
    }
    #[Route('/candidat/offre/{id}', name: 'candidat_offre_detail')]
public function show(Offre $offre): Response
{
    return $this->render('candidat/offre_detail.html.twig', [
        'offre' => $offre,
    ]);
}

}
