<?php

namespace Shop\Rubin11\view;

use Shop\Rubin11\config\Paths;

/**
 * Класс для рендеринга шаблонов
 * 
 * Отвечает за отображение шаблонов и передачу данных в них
 */
class ViewRenderer
{
    /**
     * Рендеринг шаблона
     *
     * @param string $template Путь к шаблону относительно директории views
     * @param array $data Данные для шаблона
     * @return string Отрендеренный HTML
     */
    public function render(string $template, array $data = []): string
    {
        // Определяем полный путь к шаблону
        $templatePath = $this->getTemplatePath($template);
        
        // Отладочная информация
        error_log("Trying to load template: {$template}");
        error_log("Full path: {$templatePath}");
        
        // Проверяем существование шаблона по абсолютному пути
        if (!file_exists($templatePath)) {
            // Пробуем альтернативный путь для продакшн-окружения
            $alternativePath = $this->getAlternativeTemplatePath($template);
            error_log("Alternative path: {$alternativePath}");
            
            if (file_exists($alternativePath)) {
                $templatePath = $alternativePath;
            } else {
                throw new \RuntimeException("Template not found: {$template}, Tried paths: {$templatePath}, {$alternativePath}");
            }
        }
        
        // Начинаем буферизацию вывода
        ob_start();
        
        // Распаковываем данные в переменные
        extract($data);
        
        // Подключаем шаблон
        require $templatePath;
        
        // Возвращаем содержимое буфера
        return ob_get_clean();
    }
    
    /**
     * Вывод шаблона напрямую
     *
     * @param string $template Путь к шаблону относительно директории views
     * @param array $data Данные для шаблона
     */
    public function display(string $template, array $data = []): void
    {
        echo $this->render($template, $data);
    }
    
    /**
     * Получение полного пути к шаблону
     *
     * @param string $template Путь к шаблону относительно директории views
     * @return string Полный путь к шаблону
     */
    private function getTemplatePath(string $template): string
    {
        // Разбиваем путь на части
        $parts = explode('/', $template);
        
        // Получаем имя файла (последний элемент пути)
        $fileName = end($parts);
        
        // Получаем директорию (все элементы кроме последнего)
        array_pop($parts);
        $directory = implode('/', $parts);
        
        // Формируем полный путь
        $fullPath = Paths::VIEWS_PATH;
        
        if (!empty($directory)) {
            $fullPath .= $directory . '/';
        }
        
        // Если файл уже содержит расширение
        if (pathinfo($fileName, PATHINFO_EXTENSION)) {
            $fullPath .= $fileName;
        } else {
            $fullPath .= $fileName . '.php';
        }
        
        return $fullPath;
    }
    
    /**
     * Получение альтернативного пути к шаблону (для продакшн-окружения)
     *
     * @param string $template Путь к шаблону относительно директории views
     * @return string Альтернативный путь к шаблону
     */
    private function getAlternativeTemplatePath(string $template): string
    {
        // Разбиваем путь на части
        $parts = explode('/', $template);
        
        // Получаем имя файла (последний элемент пути)
        $fileName = end($parts);
        
        // Получаем директорию (все элементы кроме последнего)
        array_pop($parts);
        $directory = implode('/', $parts);
        
        // Формируем альтернативный путь для продакшн-окружения
        $altPath = '/var/www/html/views/';
        
        if (!empty($directory)) {
            $altPath .= $directory . '/';
        }
        
        // Если файл уже содержит расширение
        if (pathinfo($fileName, PATHINFO_EXTENSION)) {
            $altPath .= $fileName;
        } else {
            $altPath .= $fileName . '.php';
        }
        
        return $altPath;
    }
}
