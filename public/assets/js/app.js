document.addEventListener('DOMContentLoaded', () => {
    console.log("Application AJAX chargée !");

   
    const forms = document.querySelectorAll('.ajax-form');

    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault(); 

            const formData = new FormData(this);
            const actionUrl = this.getAttribute('action');
            
            let errorDiv = this.querySelector('.alert-danger');
            if (!errorDiv) {
                errorDiv = document.createElement('div');
                errorDiv.className = 'alert alert-danger mt-3';
                errorDiv.style.display = 'none';
                this.appendChild(errorDiv);
            }
           
            errorDiv.style.display = 'none';
            errorDiv.innerText = '';

           
            fetch(actionUrl, {
                method: 'POST',
                body: formData
            })
            .then(response => {
                
                if (!response.ok) throw new Error("Erreur réseau ou PHP");
                return response.json();
            })
            .then(data => {
                if (data.status === 'success') {
                    
                    window.location.href = data.redirect;
                } else {
                    
                    errorDiv.innerText = data.message || "Erreur inconnue";
                    errorDiv.style.display = 'block';
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                errorDiv.innerText = "Erreur technique (Voir console F12)";
                errorDiv.style.display = 'block';
            });
        });
    });
    
    
    const btnReception = document.querySelectorAll('.btn-reception');
    btnReception.forEach(btn => {
        btn.addEventListener('click', function() {
             if(!confirm("Confirmez-vous la réception ?")) return;
             
             const id = this.getAttribute('data-id');
             const row = this.closest('tr');
             const formData = new FormData();
             formData.append('id', id);

             fetch('index.php?page=api_confirm_receipt', {
                 method: 'POST', 
                 body: formData
             })
             .then(res => res.json())
             .then(data => {
                 if(data.status === 'success') {
                     row.remove(); 
                 } else {
                     alert("Erreur : " + data.message);
                 }
             });
        });
    });
});