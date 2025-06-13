document.getElementById('trackingForm').addEventListener('submit', async (e) => {
  e.preventDefault();
  const inspectionId = document.getElementById('inspectionId').value;
  
  try {
    const response = await fetch('https://script.google.com/macros/s/YOUR_SCRIPT_ID/exec', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({
        action: 'get_inspection',
        inspectionId: inspectionId
      })
    });
    
    const data = await response.json();
    displayReport(data);
  } catch (error) {
    console.error('Error:', error);
  }
});

function displayReport(data) {
  const reportDiv = document.getElementById('report');
  reportDiv.innerHTML = `
    <h2>Inspection Report #${data.inspectionId}</h2>
    <p><strong>Date:</strong> ${new Date(data.timestamp).toLocaleString()}</p>
    <p><strong>Type:</strong> ${data.type}</p>
    <div class="photos">${data.photos.map(p => `<img src="${p.url}">`).join('')}</div>
    <p><strong>Notes:</strong> ${data.notes}</p>
  `;
}