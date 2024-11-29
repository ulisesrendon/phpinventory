const SITE_URL = 'http://phpinventory.localhost';
const API_URL = `${SITE_URL}/api/v1`;
const BACKOFFICE_URL = `${SITE_URL}/backoffice`;
const links = [
    { text: 'Index', href: 'backoffice.html' },
    { text: 'View Contents', href: 'content-list.html' },
    { text: 'New Content', href: 'content-editor.html' },
    { text: 'View Schemas', href: 'schema-list.html' },
    { text: 'New Schema', href: 'schema-create.html' },
    { text: 'Log-out', href: 'index.html' }
];

window.addEventListener('load', function(){
    const navLinksDiv = [...document.querySelectorAll('.nav-links')];
    navLinksDiv.forEach(element => {
        const a = document.createElement('a');
        links.forEach(item => {
            const link = a.cloneNode();
            link.href = `${BACKOFFICE_URL}/${item.href}`;
            link.textContent = item.text;
            element.appendChild(link);
        });
    });
});