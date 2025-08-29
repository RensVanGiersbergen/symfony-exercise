<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mailer\MailerInterface;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'contact')]
    public function contact(Request $request, MailerInterface $mailer): Response
    {
        // DRY
        $notBlank = new NotBlank([
            'message' => 'This field cannot be empty',
        ]);

        // Build the form
        $form = $this->createFormBuilder()
            // Regex pattern: [a-zA-Z\s] to allow only letters and spaces
            ->add('name', TextType::class, [
                'label' => 'Name',
                'attr' => ['class' => 'form-control', 'pattern' => '[a-zA-Z\s]+', 'title' => 'Only letters and spaces are allowed'],
                'constraints' => [
                    $notBlank,
                    new Regex([
                        'pattern' => '/^[a-zA-Z\s]+$/',
                        'message' => 'Name can only contain letters and spaces',
                    ]),
                ],
            ])
            ->add('topic', TextType::class, [
                'label' => 'Topic',
                'attr' => ['class' => 'form-control'],
                'constraints' => [
                    $notBlank,
                ],
            ])
            ->add('message', TextareaType::class, [
                'label' => 'Message',
                'attr' => ['class' => 'form-control', 'rows' => 6],
                'constraints' => [
                    $notBlank,
                ],
            ])
            ->add('send', SubmitType::class, [
                'label' => 'Send Message',
                'attr' => ['class' => 'btn btn-primary mt-3'],
            ])
            ->getForm();

        $form->handleRequest($request);

        // Process the form submission
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            // Build and send email
            $email = (new TemplatedEmail())
                ->from(new Address('noreply@example.org', 'Contact form'))
                ->to('test@example.org')
                ->subject('New message: ' . $data['topic'])
                ->htmlTemplate('emails/contact.html.twig')
                ->context([
                    'name' => $data['name'],
                    'topic' => $data['topic'],
                    'message' => $data['message'],
                ]);

            $mailer->send($email);

            $this->addFlash('success', sprintf(
                'Thanks %s! Your message about "%s" was received',
                $data['name'],
                $data['topic']
            ));

            return $this->redirectToRoute('home');
        }

        return $this->render('contact/index.html.twig', [
            'contactForm' => $form->createView(),
        ]);
    }
}
