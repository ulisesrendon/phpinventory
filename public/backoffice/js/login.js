document.querySelector('.loginform').addEventListener('submit', async function(e){
    e.preventDefault();

    const userAccess = await fetch('${API_URL}/auth/access', {
        method: 'POST',
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify({
            email: this.email.value,
            password: this.password.value
        })
    });

    const { session } = await userAccess.json();
    localStorage.setItem('session', session);
    window.location.href = 'index.html';
});