function numberDisplayFormat(numberstr, digits) {
  //const newstr = numberstr.replace(",", ".");
  const numbervalue = Number(numberstr);
  const newnumstr = numbervalue.toLocaleString('pt-BR', {minimumFractionDigits: digits});

  return newnumstr;
}

function numberDBFormat(number) {
  const noDotsNum = number.replace(".", "");
  const newNumber = noDotsNum.replace(",", ".");
  return newNumber;
}
