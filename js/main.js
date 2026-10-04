
document.addEventListener('DOMContentLoaded', function() {
    console.log('main.js zaladowany - vanilla');
    const content = document.getElementById('js-content');
    const navLinks = document.querySelectorAll('#js-navigation a');
    const progressBar = document.getElementById('reading-progress');
    const searchInput = document.getElementById('search-books');
    const fontPlus = document.getElementById('font-plus');
    const fontMinus = document.getElementById('font-minus');
    const darkToggle = document.getElementById('dark-toggle');
    const toolbar = document.querySelector('.reader-toolbar');

    function showLoader() {
        content.innerHTML = '<div class="text-center p-5"><div class="spinner-border text-danger" role="status"></div><p class="mt-2">Ładowanie księgi...</p></div>';
    }

    function loadBook(url, pushHistory = true) {
        showLoader();

  
        navLinks.forEach(a => a.classList.remove('active', 'bg-danger', 'text-white'));
        let active = document.querySelector('#js-navigation a[href="' + url + '"]');
        if (active) {
            active.classList.add('active', 'bg-danger', 'text-white');
            document.title = 'Pan Tadeusz - ' + active.textContent.trim();
        }

        fetch(url)
            .then(r => {
                if (!r.ok) throw new Error('Blad ' + r.status);
                return r.text();
            })
            .then(html => {
                content.style.opacity = 0;
                setTimeout(() => {
                    content.innerHTML = html;
                    content.style.opacity = 1;
                    applyFontSize();
                }, 100);
            })
            .catch(err => {
                content.innerHTML = '<div class="alert alert-danger">Nie udało się załadować: ' + url + '<br>' + err + '<br>Upewnij się że plik ' + url + ' istnieje na serwerze.</div>';
            });

        localStorage.setItem('ostatniaKsiega', url);
        if (pushHistory) {
            history.pushState({url: url}, '', '?ksiega=' + url);
        }
    }


    let startUrl = localStorage.getItem('ostatniaKsiega') || 'home.html';
    let params = new URLSearchParams(window.location.search);
    if (params.get('ksiega')) startUrl = params.get('ksiega');
    loadBook(startUrl, false);

   
    document.getElementById('js-navigation').addEventListener('click', function(e) {
        let a = e.target.closest('a');
        if (!a) return;
        e.preventDefault();
        loadBook(a.getAttribute('href'), true);
    });

    
    window.addEventListener('popstate', function(event) {
        if (event.state && event.state.url) {
            loadBook(event.state.url, false);
        } else {
            let p = new URLSearchParams(window.location.search).get('ksiega');
            if (p) loadBook(p, false);
        }
    });

    
    window.addEventListener('scroll', function() {
        let winScroll = document.documentElement.scrollTop;
        let height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        let scrolled = height > 0 ? (winScroll / height) * 100 : 0;
        progressBar.style.width = scrolled + '%';
    });


    if (searchInput) {
        searchInput.addEventListener('keyup', function() {
            let value = this.value.toLowerCase();
            navLinks.forEach(a => {
                let txt = a.textContent.toLowerCase();
                a.style.display = txt.includes(value) ? '' : 'none';
            });
        });
    }

  
    let currentFontSize = parseInt(localStorage.getItem('fontSize')) || 16;
    function applyFontSize() {
        content.style.fontSize = currentFontSize + 'px';
        localStorage.setItem('fontSize', currentFontSize);
    }
    if (fontPlus) fontPlus.addEventListener('click', () => {
        if (currentFontSize < 26) { currentFontSize += 2; applyFontSize(); }
    });
    if (fontMinus) fontMinus.addEventListener('click', () => {
        if (currentFontSize > 12) { currentFontSize -= 2; applyFontSize(); }
    });
    applyFontSize();

    
    let darkMode = localStorage.getItem('darkMode') === 'true';
    function applyDarkMode() {
        if (darkMode) {
            document.body.classList.add('bg-dark', 'text-light');
            content.classList.add('text-light');
            darkToggle.textContent = 'Tryb jasny';
            if (toolbar) { toolbar.classList.remove('bg-light'); toolbar.classList.add('bg-secondary'); }
        } else {
            document.body.classList.remove('bg-dark', 'text-light');
            content.classList.remove('text-light');
            darkToggle.textContent = 'Tryb nocny';
            if (toolbar) { toolbar.classList.add('bg-light'); toolbar.classList.remove('bg-secondary'); }
        }
        localStorage.setItem('darkMode', darkMode);
    }
    applyDarkMode();
    if (darkToggle) darkToggle.addEventListener('click', () => {
        darkMode = !darkMode;
        applyDarkMode();
    });
});
