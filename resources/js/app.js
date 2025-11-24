import './bootstrap';

const nav = document.getElementById('site-nav');
const mobileToggle = document.getElementById('mobile-toggle');
const mobileMenu = document.getElementById('mobile-menu');

const setNavState = () => {
    if (!nav) return;
    if (window.scrollY > 10) {
        nav.classList.add('bg-slate-950/80', 'backdrop-blur', 'border-b', 'border-white/5');
    } else {
        nav.classList.remove('bg-slate-950/80', 'backdrop-blur', 'border-b', 'border-white/5');
    }
};

window.addEventListener('scroll', setNavState);
setNavState();

if (mobileToggle && mobileMenu) {
    mobileToggle.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
    });
}

// TradingView Real-time Ticker
const ticker = document.querySelector('[data-ticker]');
if (ticker) {
    const track = ticker.querySelector('.ticker-track');
    
    // Initialize ticker items from existing HTML
    function duplicateTickerForScroll() {
        if (track && track.children.length > 0) {
            track.innerHTML += track.innerHTML;
        }
    }

    duplicateTickerForScroll();

    // Fetch data from Laravel API endpoint (which proxies TradingView)
    async function fetchTradingViewData() {
        try {
            const response = await fetch('/api/ticker', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
            });

            if (response.ok) {
                const data = await response.json();
                updateTickerData(data);
            }
        } catch (error) {
            console.error('Error fetching ticker data:', error);
        }
    }

    // Update ticker with data from API
    function updateTickerData(data) {
        if (!Array.isArray(data)) return;

        data.forEach(item => {
            if (item.symbol && item.price && item.change) {
                updateSingleTicker(item.symbol, {
                    price: item.price,
                    change: item.change,
                    changePercent: item.changePercent || 0
                });
            }
        });
    }

    // Update single ticker item
    function updateSingleTicker(symbol, data) {
        const items = document.querySelectorAll(`[data-symbol="${symbol}"]`);
        
        items.forEach(item => {
            const priceEl = item.querySelector('.ticker-price');
            const changeEl = item.querySelector('.ticker-change');
            
            if (priceEl && data.price) {
                priceEl.textContent = data.price;
            }
            
            if (changeEl && data.change) {
                changeEl.textContent = data.change;
                const isNegative = data.changePercent < 0;
                changeEl.className = `ticker-change ${isNegative ? 'text-rose-400' : 'text-emerald-400'}`;
            }
        });
    }

    // Initial fetch
    fetchTradingViewData();

    // Update every 3 seconds for real-time feel
    setInterval(fetchTradingViewData, 3000);
}

const observer = new IntersectionObserver(
    entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            }
        });
    },
    { threshold: 0.15 }
);

document.querySelectorAll('[data-animate]').forEach(element => observer.observe(element));
