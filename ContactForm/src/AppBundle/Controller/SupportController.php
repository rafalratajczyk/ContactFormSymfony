<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;

class SupportController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $form = $this->createFormBuilder()
            ->add('from', EmailType::class)
            ->add('message', TextareaType::class)
            ->add('send', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();

            dump($data);

            $message = \Swift_Message::newInstance()
                ->setSubject('Suport Form Submission')
                ->setFrom($data['from'])
                ->setTo('some email')
                ->setBody(
                    $form->getData()['message'],
                    'text/plain'
                );

            $this->get('mailer')->send($message);
        }

        return $this->render('support/index.html.twig', [
            'my_form' => $form->createView()
        ]);
    }
}
