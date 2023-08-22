document.addEventListener('keydown', function(event) {
        if (event.target.nodeName == 'INPUT' || event.target.nodeName == 'TEXTAREA') return false;
        if (event.key === 'j') { window.scrollBy(0, 50) }
        else if (event.key === 'k') { window.scrollBy(0, -50); }
});
