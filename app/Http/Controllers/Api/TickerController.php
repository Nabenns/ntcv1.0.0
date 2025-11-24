<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class TickerController extends Controller
{
    /**
     * Get real-time ticker data from Finnhub
     */
    public function index(Request $request): JsonResponse
    {
        // Finnhub API key (get from .env, fallback to demo key)
        $apiKey = config('services.finnhub.api_key', 'demo');
        
        // Finnhub symbol mapping
        // Format reference: https://finnhub.io/docs/api/symbol-search
        // (use OANDA:XXXUSD for major FX pairs, BINANCE:XXXUSDT for crypto, and plain tickers for US stocks)
        $symbols = [
            ['symbol' => 'BTC/USDT', 'finnhubSymbol' => 'BINANCE:BTCUSDT'],
            ['symbol' => 'ETH/USDT', 'finnhubSymbol' => 'BINANCE:ETHUSDT'],
            ['symbol' => 'AAPL', 'finnhubSymbol' => 'AAPL'],
            ['symbol' => 'MSFT', 'finnhubSymbol' => 'MSFT'],
            ['symbol' => 'AMZN', 'finnhubSymbol' => 'AMZN'],
            ['symbol' => 'NVDA', 'finnhubSymbol' => 'NVDA'],
            ['symbol' => 'TSLA', 'finnhubSymbol' => 'TSLA'],
        ];

        $tickerData = [];

        foreach ($symbols as $config) {
            $cacheKey = 'ticker_' . md5($config['finnhubSymbol']);
            
            // Try to get from cache first (cache for 3 seconds to avoid rate limiting)
            // Finnhub free tier: 60 calls/minute
            $cached = Cache::get($cacheKey);
            if ($cached) {
                $tickerData[] = $cached;
                continue;
            }

            try {
                // Finnhub quote endpoint
                $response = Http::withOptions(['verify' => false])
                    ->timeout(5)
                    ->get('https://finnhub.io/api/v1/quote', [
                    'symbol' => $config['finnhubSymbol'],
                    'token' => $apiKey,
                ]);
                
                if ($response->successful()) {
                    $data = $response->json();
                    
                    // Finnhub response format:
                    // { c: current price, h: high, l: low, o: open, pc: previous close, d: change, dp: change percent }
                    
                    if (isset($data['c']) && $data['c'] > 0) {
                        $price = $data['c'];
                        $changePercent = $data['dp'] ?? 0; // Change percent
                        
                        $formattedPrice = $this->formatPrice($price, $config['symbol']);
                        $formattedChange = number_format($changePercent, 2, '.', '') . '%';
                        
                        $tickerItem = [
                            'symbol' => $config['symbol'],
                            'price' => $formattedPrice,
                            'change' => ($changePercent >= 0 ? '+' : '') . $formattedChange,
                            'changePercent' => $changePercent,
                        ];

                        // Cache for 3 seconds (to stay within rate limits)
                        Cache::put($cacheKey, $tickerItem, now()->addSeconds(3));
                        
                        $tickerData[] = $tickerItem;
                    } else {
                        // Fallback if data is invalid
                        $tickerData[] = [
                            'symbol' => $config['symbol'],
                            'price' => 'N/A',
                            'change' => '0.00%',
                            'changePercent' => 0,
                        ];
                    }
                } else {
                    // Fallback on API error
                    $tickerData[] = [
                        'symbol' => $config['symbol'],
                        'price' => 'N/A',
                        'change' => '0.00%',
                        'changePercent' => 0,
                    ];
                }
            } catch (\Exception $e) {
                // Fallback on exception
                $tickerData[] = [
                    'symbol' => $config['symbol'],
                    'price' => 'N/A',
                    'change' => '0.00%',
                    'changePercent' => 0,
                ];
            }
        }

        return response()->json($tickerData);
    }

    /**
     * Format price based on symbol
     */
    private function formatPrice(float $price, string $symbol): string
    {
        if (str_contains($symbol, 'BTC') || str_contains($symbol, 'ETH')) {
            return '$' . number_format($price, 0, '.', ',');
        } elseif (str_contains($symbol, 'XAU')) {
            return '$' . number_format($price, 2, '.', ',');
        } else {
            return number_format($price, 1, '.', ',');
        }
    }
}
