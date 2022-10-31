<?php

namespace App\Controller;
use App\Entity\Car;
use App\Entity\User;

use App\Form\Type\TaskType;
use App\Form\Type\modifForm;
use App\Repository\CarRepository;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


class EcommerceController extends AbstractController

{  
   


    #[Route('', name: 'app_all')]
    public function showAll(ManagerRegistry $doctrine): Response
    {
       

       
        $car=$doctrine->getRepository(Car::class)->findBy([], ['id' => 'DESC']);
        $users = $doctrine->getRepository(User::class)->findAll();
        // a mettre en commentaire
        //$output = array_map(function ($object) { 
            //return $this -> render('ecommerce/admin.html.twig', [ 
              //  'car' => $object,
                //],);
                

        //}, $all);
        return $this->render('/ecommerce/homepage.html.twig', [
            
            "car"=> $car,
            "Users"=>$users
        ]);
    }
    
    #[Route('/Cars/{id}/delete', name: 'cars_delete')]
    public function delete(ManagerRegistry $doctrine, Car $car): Response
    {
        $entityManager = $doctrine->getManager();
        if(!$car){
            throw $this->createNotFoundException(
                'No product found for id' .$id
            );
        }
        $entityManager->remove($car);
        $entityManager->flush();

        return $this ->redirectToRoute('app_admin');
    }

   

    #[Route('/Cars/{slug}', name: 'app_affiche')]
    public function afficheProduct(string $slug, ManagerRegistry $doctrine): Response{
        
    
    
        $all = $doctrine->getRepository(Car::class)->findAll();
        $car = $doctrine->getRepository(Car:: class)->findOneBy(['id'=>$slug]);

        return $this->render('/ecommerce/infoProduct.html.twig', [
            "car"=>$car,
            'slug'=>$slug,
            "cars"=>$all,
        ]);
    }
    
   
    

    #[IsGranted('ROLE_USER')]
    #[Route('/admin', name:'app_admin')]
    public function admin(ManagerRegistry $doctrine): Response
    {   
        $all = $doctrine->getRepository(Car::class)->findAll();
       
        return $this->render('/ecommerce/admin.html.twig', [
            "cars"=>$all,
        ]);

        // renvoyer un template dans lequel on transmet $all
        // dans ce template faire une boucle sur chacun des éléments pour afficher les informations de tes voitures
    }

    // #[Route('/modif/{slug}', name:'app_modif')]
 


        #[Route('/task/new', name: 'task_new')]
        public function new(Request $request, ManagerRegistry $doctrine): Response
        {
            $entityManager = $doctrine->getManager();
            $car = new Car();
    
            $form = $this->createForm(TaskType::class, $car);
    
            $form->handleRequest($request);
    
            if ($form->isSubmitted() && $form->isValid()) {
    
                $car = $form->getData();
                $entityManager->persist($car);

                $entityManager->flush();
                return $this->redirectToRoute('app_admin');
            }
    
            return $this->renderForm('ecommerce/form.html.twig', [
                'formulaire' => $form,
            ]);
        }
    
        #[Route('/task/success', name: 'task_success')]
        public function success(): Response
        {
            return $this->render('ecommerce/success.html.twig');
        }

        #[Route('/modif/{slug}', name: 'task_modif')]
        public function modif(Request $request, ManagerRegistry $doctrine, string $slug): Response
        {
            $entityManager = $doctrine->getManager(); //lien avec la base de donnée
            $car = $doctrine->getRepository(Car::class)->find($slug); // recupération dans ma table Car d'un produit
    
            $form = $this->createForm(modifForm::class, $car); // Creation d'un formulaire en utilisan les paramétre de mon Formulaire avec les données de mon produit 
    
            $form->handleRequest($request);// on envoie a form les données de la requte  
            
            if ($form->isSubmitted() && $form->isValid()) { // test si le formulaire est valide et soumis
    
                $car = $form->getData(); //on ajoute a car notre data saisi dans notre form

                $entityManager->flush(); //nous mettons a jours notre produit dans notre table Car 
                return $this->redirectToRoute('task_success');
            }
    
            return $this->renderForm('ecommerce/modif.html.twig', [
                'form' => $form,
            ]);
        }
    
}
?>
    

