<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use App\Entity\Serveur;
use App\Entity\Site;
use Symfony\Component\HttpFoundation\Request;

class ServeurController extends AbstractController
{

    #[Route('api/getAllServers', name: 'get_servers')]
    public function index(EntityManagerInterface $entityManager): JsonResponse
    {
        $serverRepository = $entityManager->getRepository(Serveur::class);
        $servers=$serverRepository->findAll();
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers ,$encoders);
        $jsonContent = $serializer->normalize($servers, 'json',[
            'circular_reference_handler' => function ($object) {
                return $object->getId();
             }
         ]);
        return new jsonResponse($jsonContent);

    }
    #[Route('api/getAllServers/{criterea}/{valeur}', name: 'get_servers_crit')]
    public function getAllServersByCriterea(EntityManagerInterface $entityManager,string $criterea,string $valeur): JsonResponse
    {
        $serverRepository = $entityManager->getRepository(Serveur::class);
        if($criterea=='name'){$servers=$serverRepository->getServersByName($valeur);}
        elseif($criterea=='ip'){$servers=$serverRepository->getServersByIp($valeur);}
        return new jsonResponse($servers);

    }


    #[Route('api/storeServer', name: 'store_server')]
    public function store(EntityManagerInterface $entityManager): jsonResponse
    {
        $request = Request::createFromGlobals();
        $server = new Serveur();
        $server->setName($request->request->get('name'));
        $server->setIpaddress($request->request->get('ipaddress'));
        $entityManager->persist($server);
        $entityManager->flush();
        return new jsonResponse('Serveur enregistrer ');

    }

    #[Route('api/storeWebsite', name: 'store_website')]
    public function storeWebsite(EntityManagerInterface $entityManager): jsonResponse
    {
        $request = Request::createFromGlobals();
        $serveur=$entityManager->getRepository(Serveur::class)->find($request->request->get('id_serveur'));
        $site = new Site();
        $site->setName($request->request->get('name'));
        $site->setDomainname($request->request->get('domaine'));
        $site->setIpaddress($request->request->get('ipaddress'));
        $site->setActive($request->request->get('etat'));
        $site->setIdServeur($serveur);
        $entityManager->persist($site);
        $entityManager->flush();
        return new jsonResponse('Site enregistrer');

    }

    #[Route('api/deleteServer/{id}', name: 'delete_server')]
    public function deleteServer(EntityManagerInterface $entityManager,int $id): jsonResponse
    {
        $server=$entityManager->getRepository(Serveur::class)->find($id);
        $entityManager->remove($server);
        $entityManager->flush();
        return new jsonResponse('Serveur supprimer avec success');

    }

    #[Route('api/deleteWebsite/{id}', name: 'delete_website')]
    public function deleteWebsite(EntityManagerInterface $entityManager,int $id): jsonResponse
    {
        $site=$entityManager->getRepository(Site::class)->find($id);
        $entityManager->remove($site);
        $entityManager->flush();
        return new jsonResponse('website supprimer avec success');

    }

    #[Route('api/activateWebsite/{id}/{activation}', name: 'activate_website')]
    public function activateWebsite(EntityManagerInterface $entityManager,int $id,int $activation): jsonResponse
    {
        $site=$entityManager->getRepository(Site::class)->find($id);
        if($activation==1){$site->setActive(true);}else{$site->setActive(false);}
        
        $entityManager->persist($site);
        $entityManager->flush();
        return new jsonResponse('Etat website modifiée avec success');

    }

    
}
