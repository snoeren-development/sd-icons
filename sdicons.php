<?php // phpcs:ignore
declare(strict_types = 1);

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Plugin\CMSPlugin;

/**
 * SD Icons
 *
 * @author    Snoeren Development
 * @license   GNU General Public License 3 or later. See LICENSE
 * @copyright Snoeren Development (c) 2020
 * @version   1.0.0
 */

defined('_JEXEC') or die;

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
     * onBeforeCompileHead
     *
     * @return void
     */
    public function onBeforeCompileHead(): void
    {
        // Check if the plugin should run.
        if (!$this->isActive()) {
            return;
        }

        // FontAwesome
        if ((bool) $this->params->get('adapter_fontawesome', false) &&
            (bool) $this->params->get('adapter_fontawesome_include')) {
            !empty($kit = $this->params->get('adapter_fontawesome_kit'))
                ? HTMLHelper::_('script', $kit)
                : HTMLHelper::_('stylesheet', 'https://use.fontawesome.com/releases/v5.14.0/css/all.css');
        }

        // LineAwesome
        if ((bool) $this->params->get('adapter_lineawesome', false) &&
            (bool) $this->params->get('adapter_lineawesome_include')) {
            HTMLHelper::_(
                'stylesheet',
                'https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css'
            );
        }
    }

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

        // FontAwesome
        if ((bool) $this->params->get('adapter_fontawesome', false)) {
            $buffer = $this->fontAwesome($buffer);
        }

        // LineAwesome
        if ((bool) $this->params->get('adapter_lineawesome', false)) {
            $buffer = $this->lineAwesome($buffer);
        }

        $this->app->setBody($buffer);
    }

    /**
     * Determine if the plugin should be active.
     *
     * @return boolean
     */
    private function isActive(): bool
    {
        $runAt = $this->params->get('run_at', 'site');

        return $runAt === '*' || $this->app->isClient($runAt);
    }

    /**
     * Handle FontAwesome tags.
     *
     * @param  string $buffer The website buffer.
     * @return string
     */
    private function fontAwesome(string $buffer): string
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

    /**
     * Handle LineAwesome tags.
     *
     * @param  string $buffer The website buffer.
     * @return string
     */
    private function lineAwesome(string $buffer): string
    {
        if (preg_match_all('/\{la(s|b|r)\s+?(.*?)\}/', $buffer, $matches)) {
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
                        '<i class="la%s %s"></i>',
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
