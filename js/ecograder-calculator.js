document.addEventListener("DOMContentLoaded", () => {
  const input = document.getElementById('enterTraffic');
  const output = document.getElementById('carbonOutput');

  if (input && output) {
	const CO2_PER_VISIT = 0.11; // 0.11g par visite

	function updateOutput() {
	  const visits = parseFloat(input.value) || 0;
	  const grams = visits * CO2_PER_VISIT;

	  console.log("Visites :", visits, "Grammes :", grams); // Pour déboguer

	  if (grams >= 1000) { // On vérifie si le poids en grammes dépasse 1000
		const kilograms = grams / 1000;
		output.textContent = kilograms.toFixed(2) + " kg";
	  } else {
		output.textContent = grams.toFixed(2) + " g";
	  }
	}

	// Écouteur d'événement pour la saisie
	input.addEventListener('input', updateOutput);

	// Initialisation
	updateOutput();
  } else {
	console.error("Éléments non trouvés : vérifie les IDs 'enterTraffic' et 'carbonOutput'.");
  }
});
