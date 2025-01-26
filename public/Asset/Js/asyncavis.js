document.getElementById('avisForm').addEventListener('submit', async function(event) {
    event.preventDefault();

    const form = event.target;
    const formData = new FormData(form);

    try {
        const response = await fetch(form.action, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
            },
            body: formData
        });

        if (response.ok) {
            const result = await response.json(); 
            alert(result.message || 'Votre avis a été soumis avec succès !');
            form.reset();
        } else {
            const error = await response.json();
            alert('Erreur : ' + (error.message || 'Une erreur s\'est produite.'));
        }
    } catch (error) {
        console.error('Erreur lors de la requête :', error);
        alert('Une erreur s\'est produite lors de l\'envoi de votre avis.');
    }
});