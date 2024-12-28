<?php
$pageTitle = "Statistique";
$mainClass = "expert";
$titreH1 = "Résultats<span class='paris_jo' style=' margin-left: 10px; '>Statistiques</span>";
$textPge ='Découvrez les statistiques des gares les plus consultées sur notre site officiel pendant les Jeux Olympiques';
$afficherBoutonCommencer = false;

require('include/header.inc.php');
require('include/functions_depart_dest.inc.php');

?>

<h2 class="chart-title sm-title">Statistiques de consultation des stations</h2>
<canvas id="histogram"></canvas>

<script>
    // Function to fetch data from CSV file and generate histogram
function generateHistogram() {
    fetch('search_log.csv')
    .then(response => response.text())
    .then(data => {
        const rows = data.split('\n');
        const labels = [];
        const counts = [];

        // Parse data from CSV
        for (let i = 1; i < rows.length; i++) {
            const values = rows[i].split(',');
            const station = values[0];
            const count = parseInt(values[1]);
            if (station !== "Nom Station" && count !== 0) { 
                labels.push(station);
                counts.push(count);
            }
        }

        // Create histogram using Chart.js
        const ctx = document.getElementById('histogram').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: ' Nombre Consultation ',
                    data: counts,
                    backgroundColor: 'rgba(0, 123, 255, 0.6)',
                    borderColor: 'rgba(0, 123, 255, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: ' Nombre Consultation '
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Nom Station '
                        }
                    }
                }
            }
        });
    })
    .catch(error => {
        console.error('Error fetching data:', error);
    });
}

// Call the function to generate histogram when the page loads
window.addEventListener('DOMContentLoaded', generateHistogram);

    
</script>

   

<?php

require('include/footer.inc.php');

?>
