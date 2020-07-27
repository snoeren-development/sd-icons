<?php
declare(strict_types = 1);

use Joomla\CMS\Plugin\CMSPlugin;

/**
 * SD Icons
 *
 * @author    Snoeren Development
 * @license   GNU General Public License 3 or later. See LICENSE
 * @copyright Snoeren Development (c) 2020
 * @version   1.0.0
 */

class PlgSystemSDIcons extends CMSPlugin
{
    /**
     * Indicates that the language should be loaded automatically.
     *
     * @var boolean
     */
    protected $autoloadLanguage = true;

    /**
     * The application object.
     *
     * @var \Joomla\CMS\Application\CMSApplication
     */
    protected $app;

    /**
     * onAfterRender
     *
     * @return void
     */
    public function onAfterRender(): void
    {
        // Check if the plugin should run.
        if (!$this->isActive()) {
            return;
        }

        $buffer = $this->app->getBody();

        $buffer = $this->adapterFontAwesome($buffer);
        $this->app->setBody($buffer);
    }

    /**
     * Determine if the plugin should be active.
     *
     * @return boolean
     */
    private function isActive(): bool
    {
        $runAt = $this->params->get('run_at', '*');

        return $runAt === '*' ||
            ($runAt === 'site' && $this->app->isClient('site')) ||
            ($runAt === 'administrator' && $this->app->isClient('administrator'));
    }

    /**
     * Handle FontAwesome tags.
     *
     * @param  string $buffer The website buffer.
     * @return string
     */
    private function adapterFontAwesome(string $buffer): string
    {
        if (preg_match_all('/\{fa(s|l|r|b|d)\s+?(.*?)\}/', $buffer, $matches)) {
            for ($i = 0; $i < count($matches[0]); $i++) {
                $type = $matches[1][$i];
                $classes = $matches[2][$i];

                // Check if any icon classes have been found.
                if (empty($classes)) {
                    continue;
                }

                $buffer = str_replace(
                    $matches[0][$i],
                    sprintf(
                        '<i class="fa%s %s"></i>',
                        $type,
                        $classes
                    ),
                    $buffer
                );
            }
        }
        return $buffer;
    }
}
