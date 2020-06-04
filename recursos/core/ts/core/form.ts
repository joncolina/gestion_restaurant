/*================================================================================
 *--------------------------------------------------------------------------------
 *
 *	
 *
 *--------------------------------------------------------------------------------
================================================================================*/
class Formulario
{
	/*============================================================================
	 *
	 *	Coloca como valores por defecto los seleccionados
	 *
	============================================================================*/
    public static Sync(idForm: string): void
    {
        let form = document.getElementById(idForm)!;
        //@ts-ignore
        for(let i=0; i<form.elements.length; i++)
        {
            //@ts-ignore
            let input = form.elements[i];

            if(input.type == "select-one")
            {
                let options = input.getElementsByTagName("option");
                let indexSelected = input.selectedIndex;
                for(let j=0; j<options.length; j++) {
                    options[j].removeAttribute("selected");
                }
                options[ indexSelected ].setAttribute("selected", "");
            }
            else if(input.type == "checkbox")
            {
                if(input.checked) {
                    input.setAttribute("checked", "");
                } else {
                    input.removeAttribute("checked");
                }
            }
            else
            {
                input.setAttribute("value", input.value);
            }
        }

        //@ts-ignore
        form.reset();
    }

	/*============================================================================
	 *
	 *	Detecta cambios en el form
	 *
	============================================================================*/
    public static Cambio(idForm: string): boolean
    {
        let form = document.getElementById(idForm)!;
        let cambio = false;

        //@ts-ignore
        for(let i=0; i<form.elements.length; i++)
        {
            //@ts-ignore
            let input = form.elements[i];
            if(input.type == "select-one")
            {
                let option = input.selectedOptions[0];
                let selected = option.getAttribute("selected");
                if(selected == null) {
                    cambio = true;
                    break;
                }
            }
            else if(input.type == "checkbox")
            {
                if(input.checked && input.getAttribute("checked") == null) {
                    cambio = true;
                    break;
                }

                if(!input.checked && input.getAttribute("checked") != null) {
                    cambio = true;
                    break;
                }
            }
            else
            {
                let valor = input.value;
                let origial = input.getAttribute("value");

                if(origial != valor) {
                    cambio = true;
                    break;
                }
            }
        }

        return cambio;
    }
}