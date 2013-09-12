<?php

namespace Music\Bundle\WebsiteBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class Builder extends ContainerAware
{
    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $translator = $this->container->get('translator');
        $menu = $factory->createItem('root');
        
        $menu->setCurrentUri($this->container->get('request')->getRequestUri());

        $item = $menu->addChild(
            $this->getLabel($translator->trans('frontend.navbar.home'), 'home'),
            array(
                'route' => 'music_website_default_index',
            )
        );
        $item->setExtra('safe_label', true);

        $item = $menu->addChild(
            $this->getLabel($translator->trans('frontend.navbar.about'), 'align-justify'),
            array(
                'route' => 'music_website_default_about'
            )
        );
        $item->setExtra('safe_label', true);

        $item = $menu->addChild(
            $this->getLabel($translator->trans('frontend.navbar.categories'), 'list-alt'),
            array(
                'route' => 'music_website_default_categories'
            )
        );
        $item->setExtra('safe_label', true);

        $item = $menu->addChild(
            $this->getLabel($translator->trans('frontend.navbar.contact'), 'envelope'),
            array(
                'route' => 'music_website_default_contact'
            )
        );
        $item->setExtra('safe_label', true);

        return $menu;
    }

    public function rightMenu(FactoryInterface $factory, array $options)
    {
        $translator = $this->container->get('translator');
        $menu = $factory->createItem('root');

        $this->addLocaleMenu($menu);

        $item = $menu->addChild(
            $this->getLabel($translator->trans('frontend.navbar.signin'), 'user'),
            array(
                'route' => 'sonata_admin_dashboard'
            )
        );
        $item->setExtra('safe_label', true);

        return $menu;
    }

    protected function getLabel($text, $icon)
    {
        if ($icon) {
            $label[] = "<i class=\"icon-$icon\"></i>";
        }
        if ($text) {
            $label[] = $text;
        }
        return join('', $label);
    }

    protected function addLocaleMenu($menu)
    {
        $translator = $this->container->get('translator');
        $textLanguage = $translator->trans('frontend.navbar.language');

        $localeHelper = $this->container->get('sonata.intl.templating.helper.locale');
        $currentLang = $this->container->get('request')->getLocale();
        $routeName = $this->container->get('request')->get('_route');

        $languages = array(
            'en',
            'es'
        );

        $switcher = $menu->addChild(
            "$textLanguage <i class=\"flag-$currentLang\"></i>"
        );

        $switcher->setExtra('safe_label', true);
        $switcher->setAttribute('style', 'float: right');

        foreach ($languages as $language) {
            $current = false;

            if ($language == $currentLang) {
                $name = $localeHelper->language($language);
                $current = true;
            } else {
                $name = sprintf(
                    '%s (%s)',
                    $localeHelper->language($language, $language),
                    $localeHelper->language($language)
                );
            }
            $name = "<span class=\"flag-$language\">$name</span>";
            $item = $switcher->addChild(
                $name,
                array(
                    'route' => $routeName,
                    'routeParameters' => array('_locale' => $language)
                )
            );
            $item->setExtra('safe_label', true);
            $item->setCurrent($current);
        }
    }
}