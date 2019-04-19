<?php


namespace App\Controller;


use App\Entity\Session;
use App\Form\FormSessionType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SessionController extends AbstractController
{
    /**
     * @Route("/session/creation", name="session_creation")
     * @return Response $request
     * @return Response
     */
    public function ajoutSession(Request $request){
        // Récupération du formulaire
        $session = new Session();
        $form = $this->createForm(FormSessionType::class, $session);

        // On "remplit" le formulaire avec les données postées
        $form->handleRequest($request);

        // On vérifie que le formulaire est soumis et ses valeurs valides
        if($form->isSubmitted() && $form->isValid()){

            // Récupération du manager
            $manager = $this->getDoctrine()->getManager();
            // Insertion de l'article en BDD
            $manager->persist($session); // Préparation du SQL
            $manager->flush(); // Exécution du SQL
            // Ajout d'un message flash
            $this->addFlash('success', 'La session a bien été ajoutée');
            // Redirection
            return $this->redirectToRoute('session_creation', [
                'id' => $session->getId()
            ]);
        }

        // Envoi du formulaire à la vue
        return $this->render('session/creation.html.twig', [
            'createForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/session/liste", name="session_liste")
     */
    public function index(Request $request)
    {
        //Récupération du Repository
        $repository = $this->getDoctrine()->getRepository(Session::class);
        //Récupération des articles
        $session = $repository->findAll();

        $em    = $this->getDoctrine()->getManager();
        $dql   = "SELECT a FROM App\Entity\Session a";
        $query = $em->createQuery($dql);

        return $this->render('session/index.html.twig', [
            'session' => $session
        ]);
    }

    /**
     * @Route("/session/{id}/modification", name="session_modification")
     * @param Session $session
     * @return Response
     */
    public function editSession(Session $session, Request $request){
        // Récupération du formulaire
        $form = $this->createForm(FormSessionType::class, $session);

        // Remplir le formulaire avec les variables $_POST
        $form->handleRequest($request);

        // On vérifie que le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()){
            // Récupération du manager
            $manager = $this->getDoctrine()->getManager();
            // Mise à jour en BDD
            $manager->flush();
            $this->addFlash('primary', 'Votre article a bien été modifié');
            // Redirection vers le détail de l'article
            return $this->redirectToRoute('session_creation', [
                'id' => $session->getId()
            ]);
        }
        return $this->render('session/modification.html.twig',[
            'createForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/session/{id}/suppression", name="session_delete")
     * @param Session $article
     * @return Response
     */
    public function delete(Session $session): Response
    {
        // Récupération du manager
        $manager = $this->getDoctrine()->getManager();
        // Suppression de l'article
        $manager->remove($session);
        $manager->flush();
        // Ajout d'un message flash
        $this->addFlash('danger', 'Votre session va être supprimée');
        // Redirection vers la liste des articles
        return $this->redirectToRoute('session_liste');
    }
}