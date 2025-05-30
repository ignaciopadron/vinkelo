function mostrarDetalleVino(id) {
  $.ajax({
      url: 'get_wine_details.php',
      type: 'GET',
      data: {id: id},
      dataType: 'json',
      success: function(data) {
          console.log(data);
          $('#modalTitulo').text(data.nombre);
          $('#modalImagen').attr('src', data.imagen);
          $('#modalDescripcion').text(data.descripcion);
          $('#modalRegion').text(data.region); //Nombre de la región
          $('#modalVariedad').text(data.variedad); //Nombre de la uva
          $('#modalCrianza').text(data.crianza); //Nombre de la crianza
          $('#modalPrecio').text(data.precio + '€');
      },
      error: function(xhr) {
        console.error("Error en la solicitud:", xhr.statusText);
      }
  });
}

