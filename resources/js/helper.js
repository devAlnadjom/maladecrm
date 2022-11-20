export default class Helper  {

    static formatMoney (number, monnaie = ' XAF') {
        return  number.toLocaleString('en-US') + monnaie;
    };

}

