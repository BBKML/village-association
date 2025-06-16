<?php

namespace App\Helpers;

use App\Models\Setting;

class SiteSettings
{
    /**
     * Récupère un paramètre de configuration
     * 
     * @param string $key Clé du paramètre
     * @param mixed $default Valeur par défaut
     * @return mixed
     */
    public static function get($key, $default = null)
    {
        return Setting::getValue($key, $default);
    }

    /**
     * Récupère le nom du site
     * 
     * @return string
     */
    public static function siteName()
    {
        return self::get('site_name', 'Mon Application');
    }

    /**
     * Récupère l'email de contact
     * 
     * @return string|null
     */
    public static function contactEmail()
    {
        return self::get('contact_email');
    }

    /**
     * Récupère le téléphone de contact
     * 
     * @return string|null
     */
    public static function contactPhone()
    {
        return self::get('contact_phone');
    }

    /**
     * Vérifie si le mode maintenance est actif
     * 
     * @return bool
     */
    public static function isMaintenanceMode()
    {
        return (bool) self::get('maintenance_mode', false);
    }

    /**
     * Récupère le chemin du logo
     * 
     * @return string|null
     */
    public static function logoPath()
    {
        $logo = self::get('logo');
        return $logo ? \Storage::url($logo) : null;
    }

    /**
     * Récupère la description du site
     * 
     * @return string
     */
    public static function siteDescription()
    {
        return self::get('site_description', 'Description par défaut');
    }
}