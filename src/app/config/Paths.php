<?php

namespace Shop\Rubin11\config;

/**
 * Класс с константами путей для приложения
 * 
 * Централизованное хранение всех путей к файлам и директориям
 */
class Paths
{
    // Базовые пути
    public const BASE_PATH = __DIR__ . '/../../../';
    
    // Пути к представлениям
    public const VIEWS_PATH = self::BASE_PATH . 'views/';
    public const AUTH_VIEWS_PATH = self::VIEWS_PATH . 'auth/';
    public const MAIN_VIEWS_PATH = self::VIEWS_PATH . 'main/';
    public const PRODUCT_VIEWS_PATH = self::VIEWS_PATH . 'products/';
    public const PROTECTED_VIEWS_PATH = self::VIEWS_PATH . 'protected/';
    
    // Пути к ресурсам
    public const PUBLIC_PATH = self::BASE_PATH . 'public/';
    public const ASSETS_PATH = self::PUBLIC_PATH . 'assets/';
    public const CSS_PATH = self::ASSETS_PATH . 'css/';
    public const JS_PATH = self::ASSETS_PATH . 'js/';
    public const IMAGES_PATH = self::ASSETS_PATH . 'images/';
    
    // URL пути (для использования в шаблонах)
    public const BASE_URL = '/';
    public const ASSETS_URL = self::BASE_URL . 'assets/';
    public const CSS_URL = self::ASSETS_URL . 'css/';
    public const JS_URL = self::ASSETS_URL . 'js/';
    public const IMAGES_URL = self::ASSETS_URL . 'images/';
}