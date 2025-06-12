
        // Update room size value display
        function updateRoomSize() {
            document.getElementById('roomSizeValue').textContent = document.getElementById('roomSize').value + 'm²';
        }
        
        // Update auto form based on service selection
        function updateAutoForm() {
            const service = document.getElementById('autoService').value;
            document.getElementById('washOptions').classList.add('d-none');
            document.getElementById('paintOptions').classList.add('d-none');
            document.getElementById('fleetOptions').classList.add('d-none');
            
            if (service === 'wash' || service === 'detail') {
                document.getElementById('washOptions').classList.remove('d-none');
            } else if (service === 'paint') {
                document.getElementById('paintOptions').classList.remove('d-none');
            } else if (service === 'fleet') {
                document.getElementById('fleetOptions').classList.remove('d-none');
            }
        }
        
        // Calculation functions for each division
        function calculateElectrical() {
            const roomSize = parseInt(document.getElementById('roomSize').value);
            const plugPoints = parseInt(document.getElementById('plugPoints').value);
            const switchType = document.getElementById('switchType').value;
            
            let baseCost = 800;
            let sizeCost = roomSize * 20;
            let plugCost = plugPoints * 150;
            
            // Adjust for switch type
            if (switchType === 'dimmer') plugCost += plugPoints * 50;
            if (switchType === 'smart') plugCost += plugPoints * 200;
            
            // Add special connections
            if (document.getElementById('stoveCheck').checked) baseCost += 1200;
            if (document.getElementById('geyserCheck').checked) baseCost += 1500;
            if (document.getElementById('exteriorCheck').checked) baseCost += 800;
            
            const total = baseCost + sizeCost + plugCost;
            
            document.getElementById('electricalResult').classList.remove('d-none');
            document.getElementById('electricalCost').textContent = 'R' + total.toLocaleString();
        }
        
        function calculateWater() {
            const tankSize = parseInt(document.querySelector('input[name="tankSize"]:checked').value);
            const pumpType = document.getElementById('pumpType').value;
            const complexity = document.getElementById('waterComplexity').value;
            
            let cost = tankSize * 2; // Base tank cost
            
            // Add pump cost
            if (pumpType === 'manual') cost += 2500;
            if (pumpType === 'auto') cost += 4500;
            if (pumpType === 'borehole') cost += 8500;
            
            // Adjust for complexity
            if (complexity === 'medium') cost *= 1.3;
            if (complexity === 'complex') cost *= 1.6;
            
            document.getElementById('waterResult').classList.remove('d-none');
            document.getElementById('waterCost').textContent = 'R' + Math.round(cost).toLocaleString();
        }
        
        function calculateAuto() {
            const service = document.getElementById('autoService').value;
            let cost = 0;
            let includes = '';
            
            if (service === 'wash') {
                cost = 150;
                includes = 'Exterior wash and vacuum';
            } else if (service === 'detail') {
                cost = 600;
                includes = 'Full interior/exterior detailing';
            } else if (service === 'paint') {
                const area = document.querySelector('#paintOptions select').value;
                if (area === 'panel') cost = 1200;
                if (area === 'bumper') cost = 1800;
                if (area === 'half') cost = 4500;
                if (area === 'full') cost = 9500;
                includes = 'Paint and labor';
            } else if (service === 'fleet') {
                const vehicles = parseInt(document.querySelector('#fleetOptions input').value);
                cost = vehicles * 100;
                includes = vehicles + ' vehicle wash';
            }
            
            document.getElementById('autoResult').classList.remove('d-none');
            document.getElementById('autoCost').textContent = 'R' + cost.toLocaleString();
            document.getElementById('autoIncludes').textContent = 'Includes: ' + includes;
        }
        
        function calculateSecurity() {
            const system = document.getElementById('securitySystem').value;
            const size = document.getElementById('propertySize').value;
            
            let cost = 0;
            
            // Base system cost
            if (system === 'basic') cost = 3500;
            if (system === 'cctv') cost = 8500;
            if (system === 'fencing') cost = 12000;
            if (system === 'combo') cost = 22000;
            
            // Adjust for property size
            if (size === 'medium') cost *= 1.5;
            if (size === 'large') cost *= 2.5;
            if (size === 'commercial') cost *= 4;
            
            // Add features
            if (document.getElementById('monitoringCheck').checked) cost += 5000;
            if (document.getElementById('smartCheck').checked) cost += 3000;
            if (document.getElementById('backupCheck').checked) cost += 2500;
            
            document.getElementById('securityResult').classList.remove('d-none');
            document.getElementById('securityCost').textContent = 'R' + Math.round(cost).toLocaleString();
        }
        
        function calculateBuilding() {
            const service = document.getElementById('buildingService').value;
            const area = parseInt(document.getElementById('buildingArea').value);
            const condition = document.getElementById('surfaceCondition').value;
            const quality = document.getElementById('materialQuality').value;
            
            let costPerM2 = 0;
            
            // Base cost per m²
            if (service === 'painting') costPerM2 = 120;
            if (service === 'plumbing') costPerM2 = 250;
            if (service === 'roof') costPerM2 = 350;
            if (service === 'general') costPerM2 = 180;
            
            // Adjust for condition
            if (condition === 'average') costPerM2 *= 1.3;
            if (condition === 'poor') costPerM2 *= 1.8;
            
            // Adjust for quality
            if (quality === 'standard') costPerM2 *= 1.2;
            if (quality === 'premium') costPerM2 *= 1.5;
            
            const total = Math.round(area * costPerM2);
            
            document.getElementById('buildingResult').classList.remove('d-none');
            document.getElementById('buildingCost').textContent = 'R' + total.toLocaleString();
        }
        
        function calculateSolar() {
            const bill = document.getElementById('electricityBill').value;
            const system = document.getElementById('solarSystem').value;
            
            let cost = 0;
            let savings = 0;
            
            // Base system cost
            if (system === 'basic') {
                cost = 25000;
                savings = 800;
            } else if (system === 'standard') {
                cost = 55000;
                savings = 1800;
            } else if (system === 'premium') {
                cost = 95000;
                savings = 2800;
            } else if (system === 'commercial') {
                cost = 180000;
                savings = 6000;
            }
            
            // Adjust for electricity usage
            if (bill === 'low') {
                cost *= 0.7;
                savings *= 0.7;
            } else if (bill === 'high') {
                cost *= 1.4;
                savings *= 1.4;
            }
            
            // Add features
            if (document.getElementById('solarMonitoring').checked) cost += 5000;
            if (document.getElementById('solarBattery').checked) cost += 25000;
            if (document.getElementById('solarGeyser').checked) cost += 15000;
            
            document.getElementById('solarResult').classList.remove('d-none');
            document.getElementById('solarCost').textContent = 'R' + Math.round(cost).toLocaleString();
            document.getElementById('solarSavings').textContent = 'R' + Math.round(savings).toLocaleString() + '/month';
        }
        
        // Initialize the page
        document.addEventListener('DOMContentLoaded', function() {
            updateRoomSize();
            updateAutoForm();
        });