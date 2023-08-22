document.addEventListener('keypress', function(e) {
        if (e.target.nodeName === 'INPUT' || e.target.nodeName === 'TEXTAREA' || e.target.nodeName === 'BUTTON' || e.target.nodeName === 'SELECT') return;
        else if (e.key === 'k') window.scrollBy(0, -50);
        else if (e.key === 'j') window.scrollBy(0, 50);
        else return
});
