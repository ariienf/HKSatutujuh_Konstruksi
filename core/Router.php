<?php

class Router {

    public function run() {
        // Ambil URL dari request
        $url = $_SERVER['REQUEST_URI'];

        // Hapus base path dari URL
        $basePath = str_replace('/index.php', '', $_SERVER['SCRIPT_NAME']);
        $url = str_replace($basePath, '', $url);

        // Bersihkan query string dan slash
        $url = parse_url($url, PHP_URL_PATH);
        $url = trim($url, '/');

        // Pecah URL jadi segmen
        // Format: controller/method/param
        // Contoh: penyewaan/detail/5 → PenyewaanController, detail(), param=5
        $segments = explode('/', $url);

        $controllerName = !empty($segments[0]) ? $segments[0] : 'home';
        $methodName     = isset($segments[1]) && $segments[1] !== '' ? $segments[1] : 'index';
        $param          = isset($segments[2]) ? $segments[2] : null;

        // Format nama controller: home → HomeController
        $controllerClass = ucfirst(strtolower($controllerName)) . 'Controller';
        $controllerFile  = BASE_PATH . '/app/controllers/' . $controllerClass . '.php';

        // Cek apakah file controller ada
        if (!file_exists($controllerFile)) {
            $this->notFound("Controller tidak ditemukan: {$controllerClass}");
            return;
        }

        require_once $controllerFile;

        // Cek apakah class controller ada
        if (!class_exists($controllerClass)) {
            $this->notFound("Class tidak ditemukan: {$controllerClass}");
            return;
        }

        $controller = new $controllerClass();

        // Cek apakah method ada di controller
        if (!method_exists($controller, $methodName)) {
            $this->notFound("Method tidak ditemukan: {$methodName} di {$controllerClass}");
            return;
        }

        // Panggil controller->method(param)
        if ($param !== null) {
            $controller->$methodName($param);
        } else {
            $controller->$methodName();
        }
    }

    private function notFound($message = '404 - Halaman tidak ditemukan') {
        http_response_code(404);
        echo '<div style="font-family:sans-serif;padding:2rem;text-align:center;">
            <h2 style="color:#E05A1E;">404 — Halaman Tidak Ditemukan</h2>
            <p style="color:#666;">' . htmlspecialchars($message) . '</p>
            <a href="' . BASE_URL . '" style="color:#E05A1E;">← Kembali ke Beranda</a>
        </div>';
    }
}
