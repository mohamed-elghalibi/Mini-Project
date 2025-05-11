document.addEventListener("DOMContentLoaded", function() {
    const boutons = document.querySelectorAll('.filter-btn');
    const taches = document.querySelectorAll('.task');

    boutons.forEach(function(bouton) {
        bouton.addEventListener('click', function() {
            boutons.forEach(function(b) {
                b.classList.remove('active');
            });
            bouton.classList.add('active');
            
            const filtre = bouton.getAttribute('data-filter');

            if (filtre === 'all') {
                afficherToutesTaches();
            } else {
                taches.forEach(function(tache) {
                    const prio = tache.getAttribute('data-priority');
                    if (prio === filtre) {
                        tache.style.display = 'flex';
                    } else {
                        tache.style.display = 'none';
                    }
                });
            }
        });
    });

    function afficherToutesTaches() {
        const ordre = ['Urgente', 'Normale', 'Faible'];
        let zone = document.getElementById('taches_list');
        let tri = [];

        ordre.forEach(function(prio) {
            taches.forEach(function(tache) {
                if (tache.getAttribute('data-priority') === prio) {
                    tri.push(tache);
                }
            });
        });

        tri.forEach(function(tache) {
            zone.appendChild(tache);
            tache.style.display = 'flex';
        });
    }
});
