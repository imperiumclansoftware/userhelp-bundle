<?php
namespace ICS\UserhelpBundle\Twig;

use Twig\TwigFunction;
use Twig\Extension\AbstractExtension;
use Twig\Environment;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class UserHelpTwigExtension extends AbstractExtension
{
    private $twig;
    private $request;
    private $config;

    public function __construct(Environment $environment, RequestStack $requestStack, ParameterBagInterface $parameterBag)
    {
        $this->twig = $environment;
        $this->request = $requestStack->getCurrentRequest();
        $this->config = $parameterBag->get('userhelp');
    }
    public function getFilters()
    {
        return [
            
        ];
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('AddHelpJS', [$this, 'addHelpJs'],[
                'is_safe' => ['html'],
                'needs_environment' => true
            ]),
            new TwigFunction('AddHelpCSS', [$this, 'addHelpCss'],[
                'is_safe' => ['html'],
                'needs_environment' => true
            ]),
            new TwigFunction('AddHelpHtml', [$this, 'addHelpHtml'],[
                'is_safe' => ['html'],
                'needs_environment' => true
            ]),
            new TwigFunction('AddIntroJS', [$this, 'addIntroJs'],[
                'is_safe' => ['html'],
                'needs_environment' => true
            ]),
            new TwigFunction('AddIntroCSS', [$this, 'addIntroCss'],[
                'is_safe' => ['html'],
                'needs_environment' => true
            ]),
        ];
    }

    public function addHelpJs()
    {
        $helpButtonConfig = $this->config['helpButtonIdentifier'];
        if($this->useHelp())
        {
            return $this->twig->render('@Userhelp/help/helpjs.html.twig',[
                "buttonId" => $helpButtonConfig
            ]);
        }
        return '';
    }

    public function addHelpCss()
    {
        if($this->useHelp())
        {
            return $this->twig->render('@Userhelp/help/helpcss.html.twig',[]);
        }
        return '';
    }

    public function addHelpHtml()
    {
        $helpConfig = $this->config['helps'][$this->request->get('_route')];

        if($this->useHelp())
        {
            return $this->twig->render('@Userhelp/help/help.html.twig',[
                'elements' => $helpConfig['elements']
            ]);
        }
    }

    public function addIntroJs()
    {
        if($this->useIntro())
        {
            return $this->twig->render('@Userhelp/intro/introjs.html.twig',[]);
        }
        return '';
    }

    public function addIntroCss()
    {
        if($this->useIntro())
        {
            return $this->twig->render('@Userhelp/intro/introcss.html.twig',[]);
        }
        return '';
    }

    private function useHelp(): bool
    {
        $helpConfig = $this->config['helps'];
        
        if(key_exists($this->request->get('_route'),$helpConfig))
        {
            return true;
        }

        return false;
    }

    private function useIntro(): bool
    {
        $introConfig = $this->config['intros'];
        if(key_exists($this->request->get('_route'),$introConfig))
        {
            return true;
        }

        return false;
    }
}