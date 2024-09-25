<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PageController extends AbstractController
{
    private $contactos = [
        1 => ["nombre" => "Juan Pérez", "telefono" => "524142432", "email" => "juanp@ieselcaminas.org"],
        2 => ["nombre" => "Ana López", "telefono" => "58958448", "email" => "anita@ieselcaminas.org"],
        5 => ["nombre" => "Mario Montero", "telefono" => "5326824", "email" => "mario.mont@ieselcaminas.org"],
        7 => ["nombre" => "Laura Martínez", "telefono" => "42898966", "email" => "lm2000@ieselcaminas.org"],
        9 => ["nombre" => "Nora Jover", "telefono" => "54565859", "email" => "norajover@ieselcaminas.org"]
    ];

    #[Route('/page', name: 'app_page')]
    public function index(): Response
    {
        return $this->render('page/index.html.twig', [
            'controller_name' => 'PageController',
        ]);
    }
    #[Route('/', name: 'inicio')]
    public function inicio(): Response{
        return $this->render('inicio.html.twig');
    }
    #[Route('/contacto/{codigo}', name: 'ficha_contacto')]
public function ficha_contacto(int $codigo): Response{
        $contacto = ($this->contactos[$codigo] ?? null);

        if ($contacto) {
            return $this->render('ficha_contacto.html.twig', ["contacto"=> $contacto]);
        }
        return new Response("<html><body>Contacto $codigo no se ha encontrado</body>");
    }

    #[Route('/contacto/buscar/{texto}', name: 'buscar_contacto')]
    public function buscar_contacto(string $texto): Response{
        $resultados = array_filter($this->contactos, function($contacto) use ($texto){
            return strpos($contacto["nombre"], $texto) !== FALSE;
        });
        if (count($resultados)) {
            $html = "<ul>";
            foreach ($resultados as $id => $resultado) {
                $html .= "<li>" . $id . "</li>";
                $html .= "<li>" . $resultado["nombre"] . "</li>";
                $html .= "<li>" . $resultado["telefono"] . "</li>";
                $html .= "<li>" . $resultado["email"] . "</li>";
            }
            $html .= "</ul>";
            return new Response("<html><body>$html</body>");
        }
        return new Response("<html><body>No se ha encontrado ningún contacto </body>");
    }


}
