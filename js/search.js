// 検索フォームのJavaScript
document.addEventListener('DOMContentLoaded', function() {
    const searchForm = document.querySelector('.search-form');
    const filterForm = document.querySelector('.filter-form');

    // メイン検索フォームの処理
    if (searchForm) {
        searchForm.addEventListener('submit', function(e) {
            // 基本的なバリデーション
            const location = document.getElementById('location').value.trim();
            const priceMin = document.getElementById('price_min').value;
            const priceMax = document.getElementById('price_max').value;

            // 価格の範囲チェック
            if (priceMin && priceMax && parseInt(priceMin) > parseInt(priceMax)) {
                e.preventDefault();
                alert('価格の下限は上限より低く設定してください。');
                return false;
            }

            // 検索条件がすべて空の場合の警告
            if (!location && !priceMin && !priceMax && !document.getElementById('rooms').value && !document.getElementById('area').value) {
                e.preventDefault();
                alert('少なくとも1つの検索条件を入力してください。');
                return false;
            }
        });
    }

    // フィルターフォームの処理
    if (filterForm) {
        filterForm.addEventListener('submit', function(e) {
            const priceMin = document.getElementById('filter_price_min').value;
            const priceMax = document.getElementById('filter_price_max').value;

            // 価格の範囲チェック
            if (priceMin && priceMax && parseInt(priceMin) > parseInt(priceMax)) {
                e.preventDefault();
                alert('価格の下限は上限より低く設定してください。');
                return false;
            }
        });
    }

    // 価格入力のリアルタイムチェック
    const priceMinInputs = document.querySelectorAll('#price_min, #filter_price_min');
    const priceMaxInputs = document.querySelectorAll('#price_max, #filter_price_max');

    function validatePriceRange(minInput, maxInput) {
        const minValue = minInput.value;
        const maxValue = maxInput.value;

        if (minValue && maxValue && parseInt(minValue) > parseInt(maxValue)) {
            minInput.style.borderColor = '#dc2626';
            maxInput.style.borderColor = '#dc2626';
        } else {
            minInput.style.borderColor = '#e5e5e5';
            maxInput.style.borderColor = '#e5e5e5';
        }
    }

    priceMinInputs.forEach(input => {
        input.addEventListener('change', function() {
            const maxInput = document.getElementById(input.id.replace('_min', '_max'));
            if (maxInput) validatePriceRange(this, maxInput);
        });
    });

    priceMaxInputs.forEach(input => {
        input.addEventListener('change', function() {
            const minInput = document.getElementById(input.id.replace('_max', '_min'));
            if (minInput) validatePriceRange(minInput, this);
        });
    });

    // フォーム入力の保存（リロード時も保持）
    const formInputs = document.querySelectorAll('input, select');
    formInputs.forEach(input => {
        // ページ読み込み時に保存された値を復元
        const savedValue = localStorage.getItem('search_' + input.name);
        if (savedValue && !input.value) {
            input.value = savedValue;
        }

        // 入力値を保存
        input.addEventListener('change', function() {
            localStorage.setItem('search_' + this.name, this.value);
        });
    });

    // 検索結果のハイライト
    const urlParams = new URLSearchParams(window.location.search);
    const searchTerms = [];
    
    ['location', 'price_min', 'price_max', 'rooms', 'area'].forEach(param => {
        if (urlParams.get(param)) {
            searchTerms.push(urlParams.get(param));
        }
    });

    if (searchTerms.length > 0) {
        // 検索結果をハイライト表示
        const resultsInfo = document.querySelector('.search-results');
        if (resultsInfo) {
            resultsInfo.style.background = '#fff3cd';
            resultsInfo.style.padding = '15px';
            resultsInfo.style.borderRadius = '5px';
            resultsInfo.style.border = '1px solid #ffeaa7';
        }
    }
});
