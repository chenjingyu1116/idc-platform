<?php
namespace App\Http\Controllers;
class RobotsController extends Controller {
    public function index() {
        $content = "User-agent: *\nAllow: /\nDisallow: /admin/\nDisallow: /client/\nSitemap: " . url('/sitemap.xml') . "\n";
        return response($content)->header('Content-Type', 'text/plain');
    }
}
