<?php

namespace ICS\UserhelpBundle\Twig;

use Doctrine\ORM\EntityManagerInterface;
use ICS\UserhelpBundle\Entity\IntroSaver;
use Twig\TwigFunction;
use Twig\Extension\AbstractExtension;
use Twig\Environment;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Security\Core\Security;

class UserHelpTwigExtension extends AbstractExtension
{
    private $twig;
    private $request;
    private $config;
    private $doctrine;
    private $security;

    public function __construct(Environment $environment, RequestStack $requestStack, ParameterBagInterface $parameterBag, EntityManagerInterface $doctrine,Security $security)
    {
        $this->twig = $environment;
        $this->request = $requestStack->getCurrentRequest();
        $this->config = $parameterBag->get('userhelp');
        $this->doctrine = $doctrine;
        $this->security = $security;
    }
    public function getFilters()
    {
        return [];
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('AddHelpJS', [$this, 'addHelpJs'], [
                'is_safe' => ['html'],
                'needs_environment' => true
            ]),
            new TwigFunction('AddHelpCSS', [$this, 'addHelpCss'], [
                'is_safe' => ['html'],
                'needs_environment' => true
            ]),
            new TwigFunction('AddHelpHtml', [$this, 'addHelpHtml'], [
                'is_safe' => ['html'],
                'needs_environment' => true
            ]),
            new TwigFunction('AddIntroJS', [$this, 'addIntroJs'], [
                'is_safe' => ['html'],
                'needs_environment' => true
            ]),
            new TwigFunction('AddIntroCSS', [$this, 'addIntroCss'], [
                'is_safe' => ['html'],
                'needs_environment' => true
            ]),
        ];
    }

    public function addHelpJs()
    {
        $helpButtonConfig = $this->config['helpButtonIdentifier'];
        if ($this->useHelp()) {
            return $this->twig->render('@Userhelp/help/helpjs.html.twig', [
                "buttonId" => $helpButtonConfig
            ]);
        } else {
            return $this->twig->render('@Userhelp/help/help-disabled.html.twig', [
                "buttonId" => $helpButtonConfig
            ]);
        }
    }

    public function addHelpCss()
    {
        $helpColor = $this->config['helpColor'];
        if ($this->useHelp()) {
            return $this->twig->render('@Userhelp/help/helpcss.html.twig', [
                'color' => $helpColor
            ]);
        }
        return '';
    }

    public function addHelpHtml()
    {
        if ($this->useHelp()) {
            $helpConfig = $this->config['helps'][$this->request->get('_route')];
            return $this->twig->render('@Userhelp/help/help.html.twig', [
                'elements' => $helpConfig['elements']
            ]);
        }

        return '';
    }

    public function addIntroJs()
    {
        $introButtonConfig = $this->config['introButtonIdentifier'];
        $theme = $this->config['introTheme'];
        

        

        if ($this->useIntro()) {

            $user= $this->security->getUser();

            $savers=[];
            if($user != null)
            {
                $savers = $this->doctrine->getRepository(IntroSaver::class)->findBy([
                    'introRoute' => $this->request->get('_route'),
                    'userId' => $user->getId()
                ]);
            }
            
            $defaultLaunch=(count($savers) == 0);

            $introConfig = $this->config['intros'][$this->request->get('_route')];
            return $this->twig->render('@Userhelp/intro/introjs.html.twig', [
                'elements' => $introConfig['elements'],
                "buttonId" => $introButtonConfig,
                'theme' => $theme,
                'route' => $this->request->get('_route'),
                'defaultLaunch' => $defaultLaunch,
                'user' => $user
            ]);
        } else {
            return $this->twig->render('@Userhelp/intro/intro-disabled.html.twig', [
                "buttonId" => $introButtonConfig
            ]);
        }
        return '';
    }

    public function addIntroCss()
    {
        if ($this->useIntro()) {
            $theme = $this->config['introTheme'];
            return $this->twig->render('@Userhelp/intro/introcss.html.twig', [
                'theme' => $theme
            ]);
        }
        return '';
    }

    private function useHelp(): bool
    {
        $helpConfig = $this->config['helps'];

        if (key_exists($this->request->get('_route'), $helpConfig)) {
            return true;
        }

        return false;
    }

    private function useIntro(): bool
    {
        $introConfig = $this->config['intros'];
        if (key_exists($this->request->get('_route'), $introConfig)) {
            return true;
        }

        return false;
    }
}
