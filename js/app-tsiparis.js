let html, total;

function roundNumber(num, scale) {
  if (!("" + num).includes("e")) {
    return +(Math.round(num + "e+" + scale) + "e-" + scale);
  } else {
    var arr = ("" + num).split("e");
    var sig = "";
    if (+arr[1] + scale > 0) {
      sig = "+";
    }
    return +(
      Math.round(+arr[0] + "e" + sig + (+arr[1] + scale)) +
      "e-" +
      scale
    );
  }
}

function pad(num, size) {
  num = num.toString();
  while (num.length < size) num = "0" + num;
  return num;
}

function colorize() {
  jQuery(".siparis").each(function () {
    if (jQuery(this).attr("data-odemevaryok") == "yok") {
      jQuery(this).addClass("pink");
    }
    if (
      jQuery(this).attr("data-sd") == "8" &&
      jQuery(this).attr("data-pd") == "12"
    ) {
      jQuery(this).removeClass("pink").addClass("red");
    }
    if (
      jQuery(this).attr("data-pd") == "12" &&
      !jQuery(this).hasClass("pink") &&
      !jQuery(this).hasClass("red")
    ) {
      jQuery(this).addClass("yellow");
    }
    if (
      jQuery(this).attr("data-oo") != "1" &&
      !jQuery(this).hasClass("pink") &&
      !jQuery(this).hasClass("red")
    ) {
      jQuery(this).addClass("orange");
    }
    if (
      jQuery(this).attr("data-oo") == "1" &&
      !jQuery(this).hasClass("pink") &&
      !jQuery(this).hasClass("red") &&
      !jQuery(this).hasClass("orange") &&
      !jQuery(this).hasClass("yellow")
    ) {
      jQuery(this).addClass("green");
    }

    if (
      jQuery(this).attr("data-oo").includes("1") &&
      jQuery(this).attr("data-sd") == "7" &&
      (jQuery(this).attr("data-pd") == "11" ||
        jQuery(this).attr("data-pd") == "13") &&
      !jQuery(this).hasClass("green")
    ) {
      jQuery(this)
        .removeClass(["pink", "red", "orange", "yellow"])
        .addClass("green");
    }

    if (
      jQuery(this).attr("data-oo").includes("1") &&
      jQuery(this).attr("data-sd") == "13" &&
      jQuery(this).hasClass("green")
    ) {
      jQuery(this).removeClass("green").addClass("black");
    }
  });
}

function summarize_one() {
  html = "";
  html += "Siparis Adedi: " + jQuery(".siparis").length + "<br/>";

  total = parseFloat(0);
  jQuery(".total").each(function () {
    // console.log(jQuery(this).html());
    total = total + parseFloat(jQuery(this).html());
  });

  html += "Total: " + total + " TL.<br/>";

  html +=
    "Ödemesi hiç olmayan: " +
    jQuery("div[data-odemevaryok='yok']").length +
    "<br/>";

  html +=
    "Kanımca geçerli sipariş (green): " + jQuery("div.green").length + "<br/>";

  jQuery("#summary-one").html(html);
}

function summarize_second() {
  total = parseFloat(0);
  adet = parseInt(0);
  jQuery("div.green .total").each(function (index) {
    total = total + parseFloat(jQuery(this).html());
    adet = parseInt(index) + 1;
  });
  jQuery("#summary-two").html("Total: " + total + " TL.<br>Adet: " + adet);
}

function people() {
  const array = [];
  jQuery("div.green").each(function () {
    value = {
      ad:
        jQuery(this).find(".uye").html() +
        pad(jQuery(this).find(".uyeid").html(), 10),
      adet: 1,
      total: parseFloat(jQuery(this).find(".total").html()),
    };
    const exists = array.findIndex((object) => object.ad === value.ad);
    if (exists === -1) {
      array.push(value);
    } else {
      array[exists].adet += 1;
      array[exists].total += parseFloat(jQuery(this).find(".total").html());
    }
  });

  array.sort(function (a, b) {
    return b.adet - a.adet || a.ad.localeCompare(b.ad);
  });

  for (var i = 0; i < array.length; i++) {
    jQuery("#people").append(
      "Uye: " +
        array[i].ad.slice(0, -10) +
        ", Uye ID: " +
        array[i].ad.slice(-10) +
        ", Sipariş Adet: " +
        array[i].adet +
        ", Sipariş Tutar: " +
        roundNumber(array[i].total, 2) +
        " TL.<br/>"
    );
  }

  // alert(JSON.stringify(array, null, 4));
}

$(document).ready(function () {
  colorize();
  summarize_one();
  summarize_second();
  people();
});
