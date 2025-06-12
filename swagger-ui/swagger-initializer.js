window.onload = function() {
  // Begin Swagger UI call
  const ui = SwaggerUIBundle({
    url: "/swagger.yaml", // ¡RUTA ABSOLUTA CORRECTA!
    dom_id: '#swagger-ui',
    deepLinking: true,
    presets: [
      SwaggerUIBundle.presets.apis,
      SwaggerUIStandalonePreset
    ],
    plugins: [
      SwaggerUIBundle.plugins.DownloadUrl
    ],
    layout: "StandaloneLayout"
  });

  window.ui = ui;
};
