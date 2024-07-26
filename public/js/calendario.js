import { formatearFecha } from "./helpers/formatearFecha.js";
import { validarFormulario } from "./helpers/validarFormulario.js";
import { toast } from "./notificacion.js";
const cargarCalendario = async (divCalendario) => {
  const eventos = await cargarEventos();

  let calendario = new FullCalendar.Calendar(divCalendario, {
    headerToolbar: {
      end: "dayGridMonth,timeGridWeek",
      center: "title",
      left: "today prev,next",
    },
    titleFormat: { year: "numeric", month: "short", day: "numeric" },
    buttonText: {
      today: "Hoy",
      month: "Mensual",
      week: "Semanal",
      day: "Dia",
      list: "Lista",
    },
    editable: true,

    initialView: "dayGridMonth",

    dateClick: (info) => {
      let f = info.dateStr;
      const dia = new Date(f).getDay();
      if (dia === 5 || dia === 6) {
        return toast("No se Puede Agendar Sabados y Domingos", true);
      }
      modalCrear(info.dateStr);
    },

    eventClick: async (info) => {
      const evento = await cargarEvento(info.event.id);
      modalInformacion(evento);
    },

    eventResize: handleEventUpdate,

    eventDrop: handleEventUpdate,

    events: eventos,
  });
  calendario.render();
};

const cargarEventos = async () => {
  const url = `/dashboard/api/eventos`;
  try {
    const response = await fetch(url);
    const result = await response.json();
    return result;
  } catch (error) {
    console.log(error);
    return [];
  }
};

const cargarEvento = async (id) => {
  const url = `/dashboard/api/evento?id=${id}`;
  try {
    const response = await fetch(url);
    const result = await response.json();
    return result;
  } catch (error) {
    console.log(error);
  }
};

const actualizarEvento = async (event) => {
  const url = `/dashboard/api/evento/actualizar`;
  const datos = new FormData();
  datos.append("id", event.id);
  datos.append("start", formatearFecha(event.startStr));
  datos.append(
    "end",
    event.endStr ? formatearFecha(event.endStr) : formatearFecha(event.startStr)
  );

  try {
    const response = await fetch(url, {
      method: "POST",
      body: datos,
    });

    if (!response.ok) {
      // Lanza un error si la respuesta no es exitosa
      const errorData = await response.json();
      throw new Error(errorData.error);
    }

    const result = await response.json();
    toast("Evento Actualizado Correctamente");
  } catch (error) {
    toast("Error al Actualizar el Evento", true);
    console.log(error);
  }
};

const handleEventUpdate = async (info) => {
  const startDate = new Date(info.event.startStr);
  const endDate = info.event.endStr ? new Date(info.event.endStr) : startDate;

  if (esFinDeSemana(startDate.getDay() + 1) || esFinDeSemana(endDate.getDay())) {
    toast(
      "No se Puede Reagendar los Eventos los Sábados y Domingos",
      true
    );
    info.revert();
    return;
  }

  // Actualiza el evento si no está en fin de semana
  await actualizarEvento(info.event);
};

const modalCrear = (fecha) => {
  const getFormElements = () => {
    const elements = {
      title: document.querySelector("#title"),
      start: document.querySelector("#start"),
      end: document.querySelector("#end"),
      textColor: document.querySelector("#textColor"),
      backgroundColor: document.querySelector("#backgroundColor"),
    };

    const idElement = document.querySelector("#id");
    if (idElement) {
      elements.id = idElement;
    }

    return elements;
  };
  const errorMessages = {
    title: "El Titulo es Obligatorio",
    start: "Selecciona una Fecha de Inicio",
    end: "Selecciona una Fecha de Fin",
    textColor: "Selecciona un Color para el Texto",
    backgroundColor: "Selecciona un Color para el Fondo",
  };

  const contenedor = document.querySelector("#contenedor-calendario");

  // Eliminar cualquier modal existente
  const existingModal = document.querySelector("#modal-calendario");
  if (existingModal) {
    existingModal.remove();
  }

  const modal = document.createElement("div");
  modal.id = "modal-calendario"; // Asignar un ID para facilitar su eliminación
  modal.classList.add(
    "w-[90%]",
    "lg:w-1/2",
    "shadow-lg",
    "bg-white",
    "rounded-lg",
    "top-1/4",
    "left-1/2",
    "transform",
    "-translate-x-1/2",
    "-translate-y-1/2",
    "z-10",
    "absolute",
    "p-5"
  );

  const modalHeading = document.createElement("h3");
  modalHeading.classList.add(
    "text-center",
    "text-2xl",
    "text-blue-500",
    "font-bold"
  );
  modalHeading.textContent = "Llena el Siguiente Formulario";

  const modalForm = document.createElement("form");
  modalForm.classList.add("w-full", "mt-10");
  modalForm.id = "agenda-crear";
  modalForm.onsubmit = (e) => {
    e.preventDefault();
    const formElements = getFormElements();
    const formData = {};
    for (let key in formElements) {
      formData[key] = formElements[key].value;
    }

    const validado = validarFormulario(formElements, errorMessages);
    if (!validado) return;

    agendarEvento(formElements);
  };

  const campoFormTitulo = document.createElement("div");
  campoFormTitulo.classList.add("space-y-2");
  const labelTitulo = document.createElement("label");
  labelTitulo.classList.add("block", "text-xl", "font-semibold");
  labelTitulo.htmlFor = "title";
  labelTitulo.textContent = "Titulo";
  const inputTitulo = document.createElement("input");
  inputTitulo.type = "text";
  inputTitulo.id = "title";
  inputTitulo.name = "title";
  inputTitulo.placeholder = "Ingresa el Titulo";
  inputTitulo.classList.add(
    "w-full",
    "p-2",
    "rounded-md",
    "text-xl",
    "bg-gray-50"
  );

  const campoFormFechaInicio = document.createElement("div");
  campoFormFechaInicio.classList.add("space-y-2");
  const labelFechaInicio = document.createElement("label");
  labelFechaInicio.classList.add("block", "text-xl", "font-semibold");
  labelFechaInicio.htmlFor = "start";
  labelFechaInicio.textContent = "Fecha de Inicio";
  const inputFechaInicio = document.createElement("input");
  inputFechaInicio.type = "date";
  inputFechaInicio.id = "start";
  inputFechaInicio.name = "start";
  inputFechaInicio.value = fecha;
  inputFechaInicio.classList.add(
    "w-full",
    "p-2",
    "rounded-md",
    "text-xl",
    "bg-gray-50"
  );

  const campoFormFechaFin = document.createElement("div");
  campoFormFechaFin.classList.add("space-y-2");
  const labelFechaFin = document.createElement("label");
  labelFechaFin.classList.add("block", "text-xl", "font-semibold");
  labelFechaFin.htmlFor = "end";
  labelFechaFin.textContent = "Fecha de Fin";
  const inputFechaFin = document.createElement("input");
  inputFechaFin.type = "date";
  inputFechaFin.id = "end";
  inputFechaFin.name = "end";
  inputFechaFin.value = fecha;
  inputFechaFin.classList.add(
    "w-full",
    "p-2",
    "rounded-md",
    "text-xl",
    "bg-gray-50"
  );

  const campoFormTextColor = document.createElement("div");
  campoFormTextColor.classList.add("space-y-2");
  const labelTextColor = document.createElement("label");
  labelTextColor.classList.add("block", "text-xl", "font-semibold");
  labelTextColor.htmlFor = "textColor";
  labelTextColor.textContent = "Color de Texto";
  const inputTextColor = document.createElement("input");
  inputTextColor.type = "color";
  inputTextColor.id = "textColor";
  inputTextColor.name = "textColor";
  inputTextColor.value = "#ffffff";
  inputTextColor.classList.add(
    "w-1/2",
    "p-1",
    "rounded-md",
    "text-xl",
    "bg-gray-50"
  );

  const campoFormBgColor = document.createElement("div");
  campoFormBgColor.classList.add("space-y-2");
  const labelBgColor = document.createElement("label");
  labelBgColor.classList.add("block", "text-xl", "font-semibold");
  labelBgColor.htmlFor = "backgroundColor";
  labelBgColor.textContent = "Color de Fondo";
  const inputBgColor = document.createElement("input");
  inputBgColor.type = "color";
  inputBgColor.id = "backgroundColor";
  inputBgColor.name = "backgroundColor";
  inputBgColor.value = "#2324ff";
  inputBgColor.classList.add(
    "w-1/2",
    "p-1",
    "rounded-md",
    "text-xl",
    "bg-gray-50"
  );

  const campoFormBotones = document.createElement("div");
  campoFormBotones.classList.add(
    "flex",
    "justify-center",
    "gap-2",
    "items-center",
    "mt-3"
  );
  const botonAgregar = document.createElement("input");
  botonAgregar.type = "submit";
  botonAgregar.classList.add(
    "bg-blue-600",
    "p-2",
    "w-1/2",
    "rounded-lg",
    "text-white",
    "text-center"
  );
  botonAgregar.value = "Agendar";

  const botonCancelar = document.createElement("button");
  botonCancelar.type = "button";
  botonCancelar.classList.add(
    "bg-red-600",
    "p-2",
    "w-1/2",
    "rounded-lg",
    "text-white",
    "text-center"
  );
  botonCancelar.textContent = "Cancelar";
  botonCancelar.onclick = () => {
    const existingModal = document.querySelector("#modal-calendario");
    if (existingModal) {
      existingModal.remove();
    }
  };

  campoFormTitulo.appendChild(labelTitulo);
  campoFormTitulo.appendChild(inputTitulo);
  campoFormFechaInicio.appendChild(labelFechaInicio);
  campoFormFechaInicio.appendChild(inputFechaInicio);
  campoFormFechaFin.appendChild(labelFechaFin);
  campoFormFechaFin.appendChild(inputFechaFin);
  campoFormTextColor.appendChild(labelTextColor);
  campoFormTextColor.appendChild(inputTextColor);
  campoFormBgColor.appendChild(labelBgColor);
  campoFormBgColor.appendChild(inputBgColor);
  campoFormBotones.appendChild(botonAgregar);
  campoFormBotones.appendChild(botonCancelar);

  modalForm.appendChild(campoFormTitulo);
  modalForm.appendChild(campoFormFechaInicio);
  modalForm.appendChild(campoFormFechaFin);
  modalForm.appendChild(campoFormTextColor);
  modalForm.appendChild(campoFormBgColor);
  modalForm.appendChild(campoFormBotones);

  modal.appendChild(modalHeading);
  modal.appendChild(modalForm);

  contenedor.appendChild(modal);
};

const modalInformacion = ({ title, empleado = null, start, end }) => {
  const contenedor = document.querySelector("#contenedor-calendario");

  // Eliminar cualquier modal existente
  const existingModal = document.querySelector("#modal-calendario");
  if (existingModal) {
    existingModal.remove();
  }
  const modal = document.createElement("div");
  modal.id = "modal-calendario"; // Asignar un ID para facilitar su eliminación
  modal.classList.add(
    "w-[90%]",
    "lg:w-1/2",
    "shadow-lg",
    "bg-white",
    "rounded-lg",
    "top-1/4",
    "left-1/2",
    "transform",
    "-translate-x-1/2",
    "-translate-y-1/2",
    "z-10",
    "absolute",
    "p-5"
  );

  const modalHeading = document.createElement("h3");
  modalHeading.classList.add(
    "text-center",
    "text-2xl",
    "text-blue-800",
    "font-bold"
  );
  modalHeading.textContent = "Informacion del Evento";

  const modalTitulo = document.createElement("p");
  modalTitulo.textContent = "Titulo: ";
  modalTitulo.classList.add(
    "text-2xl",
    "text-gray-600",
    "font-semibold",
    "mt-3"
  );
  const modalTituloSpan = document.createElement("span");
  modalTituloSpan.textContent = title;
  modalTituloSpan.classList.add("text-blue-500");
  modalTitulo.appendChild(modalTituloSpan);

  const modalEmpleado = document.createElement("p");
  modalEmpleado.textContent = "Empleado a Cargo: ";
  modalEmpleado.classList.add(
    "text-2xl",
    "text-gray-600",
    "font-semibold",
    "mt-3"
  );
  const modalEmpleadoSpan = document.createElement("span");
  modalEmpleadoSpan.textContent = empleado;
  modalEmpleadoSpan.classList.add("text-blue-500");
  modalEmpleado.appendChild(modalEmpleadoSpan);

  const modalFechaInicio = document.createElement("p");
  modalFechaInicio.textContent = "Fecha de Inicio: ";
  modalFechaInicio.classList.add(
    "text-2xl",
    "text-gray-600",
    "font-semibold",
    "mt-3"
  );
  const modalFechaInicioSpan = document.createElement("span");
  modalFechaInicioSpan.textContent = Intl.DateTimeFormat("es-MX", {
    dateStyle: "long",
  }).format(new Date(start));
  modalFechaInicioSpan.classList.add("text-blue-500");
  modalFechaInicio.appendChild(modalFechaInicioSpan);

  const modalFechaFin = document.createElement("p");
  modalFechaFin.textContent = "Fecha de Fin: ";
  modalFechaFin.classList.add(
    "text-2xl",
    "text-gray-600",
    "font-semibold",
    "mt-3"
  );
  const modalFechaFinSpan = document.createElement("span");
  modalFechaFinSpan.textContent = Intl.DateTimeFormat("es-MX", {
    dateStyle: "long",
  }).format(new Date(end));
  modalFechaFinSpan.classList.add("text-blue-500");
  modalFechaFin.appendChild(modalFechaFinSpan);

  const modalCerrar = document.createElement("button");
  modalCerrar.type = "button";
  modalCerrar.classList.add(
    "bg-red-600",
    "p-2",
    "w-auto",
    "rounded-lg",
    "text-white",
    "text-center",
    "mt-3"
  );
  modalCerrar.textContent = "Cerrar";
  modalCerrar.onclick = () => {
    const existingModal = document.querySelector("#modal-calendario");
    if (existingModal) {
      existingModal.remove();
    }
  };

  modal.appendChild(modalHeading);
  modal.appendChild(modalTitulo);
  empleado ? modal.appendChild(modalEmpleado) : "";
  modal.appendChild(modalFechaInicio);
  modal.appendChild(modalFechaFin);
  modal.appendChild(modalCerrar);

  contenedor.appendChild(modal);
};

const agendarEvento = async (formData) => {
  const datos = new FormData();
  Object.keys(formData).forEach((key) => {
    datos.append(key, formData[key].value);
  });

  const url = "/dashboard/agenda/agregar";

  try {
    const response = await fetch(url, {
      method: "POST",
      body: datos,
    });

    if (!response.ok) {
      // Lanza un error si la respuesta no es exitosa
      const errorData = await response.json();
      throw new Error(errorData.error);
    }
    const result = await response.json();
    toast("Evento Agendado Correctamente");

    //redireccionamos si se agrego correctamente
    setTimeout(() => {
      window.location.href = "/dashboard/agenda";
    }, 3500);
  } catch (error) {}
};

const esFinDeSemana = (dia) => {
  return dia === 6 || dia === 0; // 0 es domingo y 6 es sábado
};
export { cargarCalendario };
