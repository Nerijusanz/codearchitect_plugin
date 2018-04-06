class Supports_module {

    constructor(){
        this.init();
    }

    init(){

        $("#datepicker").datepicker();
        $("#datepicker").datepicker("option", "showAnim","slideDown");

    }
}

export default Supports_module;
