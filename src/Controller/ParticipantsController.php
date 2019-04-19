<?php


namespace App\Controller;

use App\Entity\Participants;
use App\Form\ParticipantSessionType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ParticipantsController extends AbstractController
{
    /**
     * @Route("/participation/creation", name="participants_creation")
     * @return Response $request
     * @return Response
     */
    public function ajoutParticipant(Request $request){
        // Récupération du formulaire
        $participants= new Participants();
        $form = $this->createForm(ParticipantSessionType::class, $participants);

        // On "remplit" le formulaire avec les données postées
        $form->handleRequest($request);

        // On vérifie que le formulaire est soumis et ses valeurs valides
        if($form->isSubmitted() && $form->isValid()){
            // Récupération du manager
            $manager = $this->getDoctrine()->getManager();
            // Insertion de l'article en BDD
            $manager->persist($participants); // Préparation du SQL

            foreach ($participants->getFiles() as $file){
                $file->setParticipants($participants);
                $manager->persist($file);
            }

            $manager->flush(); // Exécution du SQL
            // Ajout d'un message flash
            $this->addFlash('success', 'Vous allez recevoir un mail de confirmation');
            // Redirection
            return $this->redirectToRoute('participants_creation', [
                'id' => $participants->getId()
            ]);
        }

        return $this->render('participation/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}