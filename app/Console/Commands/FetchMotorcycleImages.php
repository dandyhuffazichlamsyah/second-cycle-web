<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use Illuminate\Support\Facades\Http;

class FetchMotorcycleImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'products:fetch-images';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetches motorcycle images from Wikipedia for products without images';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $products = Product::whereNull('image')->orWhere('image', '')->get();
        
        $this->info("Found {$products->count()} products without images.");

        foreach ($products as $product) {
            $this->info("Fetching image for: {$product->name}");
            
            try {
                // Prepare exact search query for Bing Images
                $searchQuery = urlencode($product->name . ' motor original');
                $searchUrl = "https://www.bing.com/images/search?q={$searchQuery}&form=HDRSC2&first=1";
                
                $this->line("Searching Bing for: {$product->name}");
                
                $html = Http::withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36'
                ])->timeout(15)->get($searchUrl)->body();
                
                preg_match_all('/murl&quot;:&quot;(https?[^&]+)&quot;/', $html, $matches);
                if (empty($matches[1])) {
                    preg_match_all('/murl":"(https?[^"]+)"/', $html, $matches);
                }
                
                $imageUrl = null;
                if (!empty($matches[1])) {
                    // Filter out very small or likely irrelevant icon images
                    foreach ($matches[1] as $url) {
                        if (!str_contains(strtolower($url), 'icon') && !str_contains(strtolower($url), 'logo')) {
                            $imageUrl = $url;
                            break;
                        }
                    }
                }
                
                if ($imageUrl) {
                    try {
                        $imageContent = Http::timeout(15)->get($imageUrl)->body();
                        $filename = 'products/bing_' . time() . '_' . rand(1000, 9999) . '.jpg';
                        \Illuminate\Support\Facades\Storage::disk('public')->put($filename, $imageContent);
                        
                        $product->image = $filename;
                        $product->save();
                        $this->info("Assigned image from Bing: {$filename}");
                    } catch (\Exception $e) {
                        $this->error("Failed to download image from Bing: " . $e->getMessage());
                    }
                } else {
                    $this->warn("No image found on Bing for {$product->name}. Using Picsum fallback.");
                    try {
                        $imageContent = Http::timeout(15)->get('https://picsum.photos/800/600')->body();
                        $filename = 'products/dummy_' . time() . '_' . rand(1000, 9999) . '.jpg';
                        \Illuminate\Support\Facades\Storage::disk('public')->put($filename, $imageContent);
                        
                        $product->image = $filename;
                        $product->save();
                        $this->info("Assigned dummy image: {$filename}");
                    } catch (\Exception $e) {
                        $this->error("Failed to download dummy image: " . $e->getMessage());
                    }
                }
                
            } catch (\Exception $e) {
                $this->error("Failed to fetch image for {$product->name}: " . $e->getMessage());
            }
            
            // Sleep to avoid rate limits
            sleep(1);
        }
        
        $this->info("Done fetching images.");
    }
}
