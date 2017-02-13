angular
    .module('altaApp', [])
    .controller('altaAppCtrl', ValidarFormulario);
    
function ValidarFormulario() {
    //Modelo para el campo del nombre
    this.nombre;
    //Atributos de clase para la etiqueta y el input del nombre
    this.clase_nombre = "has-error";
    //Atributos de clase para el mensaje de información del nombre
    this.clase_mensaje_nombre = "text-info";    
    //Texto del mensaje de información para el nombre
    this.mensaje_nombre = "El nombre debe tener al menos 3 caracteres";

    //Modelo para el campo del email
    this.email;
    //Atributos de clase para la etiqueta y el input del email
    this.clase_email = "has-error";
    //Atributos de clase para el mensaje de información del email
    this.clase_mensaje_email = "text-info";
    //Texto del mensaje de información para el email
    this.mensaje_email = "ejemplo@ejemplo.dominio"

    //Modelo para el campo de la contraseña1
    this.pass1;
    //Atributos de clase para la etiqueta y el input de la contraseña1
    this.clase_pass1 = "has-error";
    //Atributos de clase para el mensaje de información de la contraseña1
    this.clase_mensaje_pass1 = "text-info";
    //Texto del mensaje de información para la longitud de la contraseña
    this.mensaje_pass1 = "La contraseña debe tener una longitud mínima de 8 caracteres";
    
    //Modelo para el campo de la contraseña2
    this.pass2;
    //Atributos de clase para la etiqueta y el input de la contraseña2
    this.clase_pass2 = "has-error";
    //Atributos de clase para el mensaje de información de la contraseña2
    this.clase_mensaje_pass2 = "text-info";
    //texto del mensaje de información para la repetición de la contraseña
    this.mensaje_pass2 = "Las contraseñas no pueden ser vacias.";

    /*
     * Función que comprueba que el nombre tenga al menos 3 caracteres
     */
    this.comprobarNombre = function() {
        if(this.nombre.length >= 3)
        {
            this.clase_nombre = "has-success";
            this.clase_mensaje_nombre = "hidden";
        } else
        {
            this.clase_nombre = "has-error";
            this.clase_mensaje_nombre = "text-info";
        }
    }
    
    /*
     * Función que comprueba el formato del email
     */
    this.comprobarEmail = function() {
        if(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/.test(this.email))
        {
            this.clase_email = "has-success";
            this.clase_mensaje_email = "hidden";
        }else
        {
            this.clase_email = "has-error";
            this.clase_mensaje_email = "text-info";
        }
    }
    
    /*
     * Función que comprueba que la contraseña tenga al menos 8 caracteres
     */
    this.comprobarLongitud = function() {
        if(this.pass1.length >= 8) {
            this.clase_pass1 = "has-success";
            this.clase_mensaje_pass1 = "hidden";
        } else
        {
            this.clase_pass1 = "has-error";
            this.clase_mensaje_pass1 = "text-info";
        }
    }

    /*
     * Función que comprueba que la contraseña no esté vacía y que sean iguales
     */
    this.comprobarPass = function() {
        if(this.pass1.length == 0 || this.pass2.length == 0)
        {
            this.mensaje = "Las contraseñas no pueden ser vacías.";
            this.clase_pass2 = "text-info"
        }else
        {
            if(this.pass1 === this.pass2)
            {
                this.clase_pass2 = "has-success";
                this.clase_mensaje_pass2 = "hidden";
            }else
            {
                this.clase_pass2 = "has-error";
                this.clase_mensaje_pass2 = "text-info";
            }
        }
    }
}