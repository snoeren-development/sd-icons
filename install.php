<?php
declare(strict_types = 1);

class PlgSystemSDIconsInstallerScript
{
    /**
     * Runs after installation.
     *
     * @return void
     */
    public function install(): void
    {
        echo <<<HTML
<style>
    .btn-sd {
        display: inline-block;
        background-color: #ee5a24;
        color: #fff;
        padding: .5rem 1rem;
        margin-top: 1rem;
    }
    .btn-sd:hover {
        color: #fff;
        text-decoration: none;
    }
    .btn-outline-sd {
        border: 1px solid #ee5a24;
        padding: .5rem 1rem;
        margin-top: 1rem;
        display: inline-block;
    }
</style>
<div class="row" style="margin-bottom: 30px;">
    <div class="span1">&nbsp;</div>
    <div class="span3 col-md-4">
        <img
            src="../media/plg_system_sdicons/images/sd-icons-logo.png"
            alt="SD Icons Logo"
            style="width:100%" />
    </div>

    <div class="span6 col-md-7">
        <h2>SD Icons</h2>

        Embed font icons onto your Joomla-powered website using SD Icons!<br>

        <ul class="inline list-inline">
            <li class="list-inline-item">
                <a
                    href="https://docs.snoerendevelopment.com/sd-icons"
                    class="btn-outline-sd"
                    target="_blank">
                    Getting started
                </a>
            </li>
        </ul>
    </div>
</div>
HTML;
    }
}
