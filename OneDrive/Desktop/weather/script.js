// Configuration de l'API
const API_KEY = '27a2a59f5f4ce92fb2a7f8fa66d0a97b'; // Remplacez par votre clé API OpenWeatherMap
const BASE_URL = 'https://api.openweathermap.org/data/2.5';

// Éléments du DOM
const cityInput = document.getElementById('cityInput');
const searchButton = document.getElementById('searchButton');
const weatherResults = document.getElementById('weatherResults');
const errorMessage = document.getElementById('errorMessage');
const searchError = document.getElementById('searchError');
const loaderContainer = document.getElementById('loaderContainer');

// Fonction pour récupérer la météo actuelle
async function getCurrentWeather(city) {
  try {
    const response = await fetch(
      `${BASE_URL}/weather?q=${city}&units=metric&lang=fr&appid=${API_KEY}`
    );
    
    if (!response.ok) {
      const errorData = await response.json();
      throw new Error(
        response.status === 404 
          ? "Ville introuvable" 
          : `Erreur (${response.status}): ${errorData.message || "Erreur de serveur"}`
      );
    }
    
    const data = await response.json();
    return data;
  } catch (error) {
    console.error('Erreur lors de la récupération des données météo actuelles:', error);
    throw error;
  }
}

// Fonction pour récupérer les prévisions météo
async function getForecast(city) {
  try {
    const response = await fetch(
      `${BASE_URL}/forecast?q=${city}&units=metric&lang=fr&appid=${API_KEY}`
    );
    
    if (!response.ok) {
      throw new Error(`Erreur HTTP: ${response.status}`);
    }
    
    const data = await response.json();
    
    // Extraire les données horaires pour les 3 prochaines heures (1 entrée toutes les 3 heures)
    const hourlyForecast = data.list.slice(0, 1);
    
    // Extraire les prévisions à court terme (5 prochaines entrées)
    const shortTermForecast = data.list.slice(0, 5);
    
    return {
      hourly: hourlyForecast,
      shortTerm: shortTermForecast
    };
  } catch (error) {
    console.error('Erreur lors de la récupération des prévisions:', error);
    throw error;
  }
}

// Fonction principale qui récupère les données météo
async function getWeatherData(city) {
  try {
    // Récupérer les données en parallèle
    const [currentWeather, forecastData] = await Promise.all([
      getCurrentWeather(city),
      getForecast(city)
    ]);
    
    // Extraire les prévisions
    const { hourly, shortTerm } = forecastData;
    
    // Générer les prévisions pour les 3 prochaines heures
    const hourlyData = [];
    const now = new Date(currentWeather.dt * 1000);
    
    for (let i = 1; i <= 3; i++) {
      const hourTime = new Date(now);
      hourTime.setHours(hourTime.getHours() + i);
      
      // Interpolation entre la valeur actuelle et la prochaine prévision
      const currentTemp = currentWeather.main.temp;
      const nextTemp = hourly[0].main.temp;
      const tempDiff = nextTemp - currentTemp;
      const interpolatedTemp = currentTemp + (tempDiff * (i / 3));
      
      hourlyData.push({
        timestamp: hourTime.getTime(),
        temperature: Math.round(interpolatedTemp),
        icon: i === 3 ? hourly[0].weather[0].icon : currentWeather.weather[0].icon,
        description: i === 3 ? hourly[0].weather[0].description : currentWeather.weather[0].description
      });
    }
    
    // Formater les données
    const formattedData = {
      current: {
        city: currentWeather.name,
        country: currentWeather.sys.country,
        temperature: Math.round(currentWeather.main.temp),
        feelsLike: Math.round(currentWeather.main.feels_like),
        description: currentWeather.weather[0].description,
        icon: currentWeather.weather[0].icon,
        humidity: currentWeather.main.humidity,
        windSpeed: (currentWeather.wind.speed * 3.6).toFixed(1), // m/s en km/h
        pressure: currentWeather.main.pressure,
        visibility: (currentWeather.visibility / 1000).toFixed(1), // m en km
        timestamp: currentWeather.dt * 1000
      },
      hourly: hourlyData,
      daily: shortTerm.map(item => ({
        timestamp: item.dt * 1000,
        temperature: Math.round(item.main.temp),
        feelsLike: Math.round(item.main.feels_like),
        description: item.weather[0].description,
        icon: item.weather[0].icon,
        humidity: item.main.humidity,
        windSpeed: (item.wind.speed * 3.6).toFixed(1),
        pressure: item.main.pressure,
        datetime: new Date(item.dt * 1000).toLocaleString()
      }))
    };
    
    return formattedData;
  } catch (error) {
    console.error('Erreur lors de la récupération des données météo:', error);
    throw error;
  }
}

// Fonction pour obtenir l'icône météo avec Font Awesome
function getWeatherIcon(iconCode) {
  const iconMap = {
    '01d': '<i class="fas fa-sun text-yellow-400"></i>',
    '01n': '<i class="fas fa-moon text-blue-200"></i>',
    '02d': '<i class="fas fa-cloud-sun text-yellow-300"></i>',
    '02n': '<i class="fas fa-cloud-moon text-blue-300"></i>',
    '03d': '<i class="fas fa-cloud text-gray-300"></i>',
    '03n': '<i class="fas fa-cloud text-gray-300"></i>',
    '04d': '<i class="fas fa-cloud text-gray-400"></i>',
    '04n': '<i class="fas fa-cloud text-gray-400"></i>',
    '09d': '<i class="fas fa-cloud-rain text-blue-400"></i>',
    '09n': '<i class="fas fa-cloud-rain text-blue-400"></i>',
    '10d': '<i class="fas fa-cloud-showers-heavy text-blue-500"></i>',
    '10n': '<i class="fas fa-cloud-showers-heavy text-blue-500"></i>',
    '11d': '<i class="fas fa-bolt text-yellow-500"></i>',
    '11n': '<i class="fas fa-bolt text-yellow-500"></i>',
    '13d': '<i class="fas fa-snowflake text-blue-100"></i>',
    '13n': '<i class="fas fa-snowflake text-blue-100"></i>',
    '50d': '<i class="fas fa-smog text-gray-300"></i>',
    '50n': '<i class="fas fa-smog text-gray-300"></i>'
  };
  
  return iconMap[iconCode] || `<img src="https://openweathermap.org/img/wn/${iconCode}@2x.png" alt="Météo">`;
}

// Fonction pour formater le jour de la semaine
function formatDay(timestamp) {
  const days = ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
  const date = new Date(timestamp);
  return days[date.getDay()];
}

// Fonction pour afficher les données météo
function displayWeatherData(data) {
  // Titre et date
  document.getElementById('cityName').textContent = `${data.current.city}, ${data.current.country}`;
  document.getElementById('currentDate').textContent = new Date(data.current.timestamp).toLocaleDateString('fr-FR', {
    weekday: 'long',
    year: 'numeric',
    month: 'long',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  });
  
  // Météo actuelle
  document.getElementById('temperature').textContent = `${data.current.temperature}°C`;
  document.getElementById('feelsLike').textContent = `${data.current.feelsLike}°C`;
  document.getElementById('weatherDescription').textContent = data.current.description;
  document.getElementById('humidity').textContent = `${data.current.humidity}%`;
  document.getElementById('wind').textContent = `${data.current.windSpeed} km/h`;
  document.getElementById('pressure').textContent = `${data.current.pressure} hPa`;
  document.getElementById('visibility').textContent = `${data.current.visibility} km`;
  
  // Afficher l'icône météo OpenWeatherMap
  document.getElementById('weatherIcon').innerHTML = getWeatherIcon(data.current.icon);
  
  // Ajouter l'image d'icône météo à côté de la description
  const iconImg = document.getElementById('weatherIconImg');
  iconImg.src = `https://openweathermap.org/img/wn/${data.current.icon}@2x.png`;
  iconImg.alt = data.current.description;
  
  // Prévisions horaires
  const hourlyContainer = document.getElementById('hourlyForecast');
  hourlyContainer.innerHTML = '';
  
  data.hourly.forEach(hourData => {
    const hour = new Date(hourData.timestamp);
    const hourlyCard = document.createElement('div');
    hourlyCard.className = 'hourly-card card';
    hourlyCard.innerHTML = `
      <div class="text-center">
        <h4 class="hour-label">${hour.getHours()}:00</h4>
        <div class="hourly-icon">
          ${getWeatherIcon(hourData.icon)}
        </div>
        <div class="flex justify-center items-center mb-2">
          <img src="https://openweathermap.org/img/wn/${hourData.icon}.png" alt="${hourData.description}" class="w-10 h-10">
          <div class="hourly-temp">${hourData.temperature}°C</div>
        </div>
        <div class="hourly-desc">${hourData.description}</div>
      </div>
    `;
    hourlyContainer.appendChild(hourlyCard);
  });
  
  // Prévisions quotidiennes
  const dailyContainer = document.getElementById('dailyForecast');
  dailyContainer.innerHTML = '';
  
  data.daily.forEach(day => {
    const date = new Date(day.timestamp);
    const dayName = formatDay(day.timestamp);
    
    const dailyCard = document.createElement('div');
    dailyCard.className = 'daily-card card';
    dailyCard.innerHTML = `
      <div>
        <h4 class="day-label">${dayName.substring(0, 3)} ${date.toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit' })}</h4>
        <div class="daily-icon">
          ${getWeatherIcon(day.icon)}
        </div>
        <div class="flex justify-center items-center mb-2">
          <img src="https://openweathermap.org/img/wn/${day.icon}.png" alt="${day.description}" class="w-10 h-10 mr-1">
          <div class="daily-temp">${day.temperature}°C</div>
        </div>
        <div class="daily-desc">${day.description}</div>
        
        <div class="daily-details">
          <div>
            <i class="fas fa-tint"></i> ${day.humidity}%
          </div>
          <div>
            <i class="fas fa-wind"></i> ${day.windSpeed} km/h
          </div>
        </div>
      </div>
    `;
    dailyContainer.appendChild(dailyCard);
  });
  
  // Afficher les résultats
  weatherResults.classList.remove('hidden');
}

// Gestionnaire pour le bouton de recherche
searchButton.addEventListener('click', handleSearch);

// Recherche avec la touche Entrée
cityInput.addEventListener('keyup', function(event) {
  if (event.key === 'Enter') {
    handleSearch();
  }
});

// Fonction principale de recherche
async function handleSearch() {
  const city = cityInput.value.trim();
  
  if (!city) {
    // Afficher l'erreur sous la barre de recherche
    searchError.querySelector('.search-error-message').textContent = 'Veuillez entrer le nom d\'une ville';
    searchError.classList.remove('hidden');
    return;
  }
  
  try {
    // Masquer les résultats précédents et les erreurs
    weatherResults.classList.add('hidden');
    errorMessage.classList.add('hidden');
    searchError.classList.add('hidden');
    
    // Nous ne montrons plus l'indicateur de chargement
    // loaderContainer.classList.remove('hidden');
    
    // Récupérer les données météo
    const weatherData = await getWeatherData(city);
    
    // Afficher les données
    displayWeatherData(weatherData);
  } catch (error) {
    // Afficher l'erreur sous la barre de recherche
    let errorMessage = "Une erreur s'est produite lors de la recherche.";
    
    if (error.message.includes("Ville introuvable")) {
      errorMessage = `"${city}" introuvable. Vérifiez l'orthographe ou essayez une autre ville.`;
    } else if (error.message.includes("Invalid API key")) {
      errorMessage = "Clé API invalide. Vérifiez votre configuration.";
    } else if (error.message.includes("timeout") || error.message.includes("network")) {
      errorMessage = "Problème de connexion au service météo. Vérifiez votre connexion internet.";
    }
    
    searchError.querySelector('.search-error-message').textContent = errorMessage;
    searchError.classList.remove('hidden');
    
    // Masquer la grande zone d'erreur (utiliser seulement celle sous la recherche)
    errorMessage.classList.add('hidden');
    console.error('Erreur:', error);
  }
}

// Charger Paris par défaut au démarrage
window.addEventListener('DOMContentLoaded', () => {
  cityInput.value = 'Paris';
  handleSearch();
});