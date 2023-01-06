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

function createButtons() {
  const buttonColors = [
    "pink",
    "red",
    "gray",
    "yellow",
    "orange",
    "green",
    "black",
  ];
  buttonColors.forEach((element) => {
    html = `<button class="btn btn-primary" onclick="showClass('${element}');">show ${element}</button>`;
    jQuery("#button-container").append(html);
  });
}

function colorize() {
  jQuery(".siparis").each(function () {
    // Color pink begins
    // There is no payment record
    if (jQuery(this).attr("data-odemevaryok") == "yok") {
      jQuery(this).addClass("pink");
    }
    // Color pink ends

    // Color red begins
    // Sipariş durumu: 8 (İptal Edildi) - - Paketleme durumu İptal Edildi 12
    // Ödeme onay 0 (sıfır)
    if (
      jQuery(this).attr("data-sd") == "8" &&
      jQuery(this).attr("data-pd") == "12" &&
      jQuery(this).attr("data-oo") == "0"
    ) {
      jQuery(this).removeClass("pink").addClass("red");
    }
    // Color red ends

    // Color gray begins
    // Sipariş durumu: 8 (İptal Edildi) - - Paketleme durumu İptal Edildi 12
    // Ödeme onay 1 (bir) içeriyorsa
    // Bunlar iade olmalı çünkü ödeme yapılmış
    if (
      jQuery(this).attr("data-sd") == "8" &&
      jQuery(this).attr("data-pd") == "12" &&
      jQuery(this).attr("data-oo").includes("1")
    ) {
      jQuery(this).removeClass("pink").addClass("gray");
    }

    // Sipariş durumu: 0 (Siparişiniz Alındı) - - Paketleme durumu İptal Edildi 12
    // Ödeme onay 1 (bir) içeriyorsa
    // Bunlar iade olmalı çünkü ödeme yapılmış
    if (
      jQuery(this).attr("data-sd") == "0" &&
      jQuery(this).attr("data-pd") == "12" &&
      jQuery(this).attr("data-oo").includes("1")
    ) {
      jQuery(this).removeClass("pink").addClass("gray");
    }

    // Sipariş durumu: 4 (Paketleniyor) - - Paketleme durumu İptal Edildi 12
    // Ödeme onay 1 (bir) içeriyorsa
    // Bunlar iade olmalı çünkü ödeme yapılmış
    if (
      jQuery(this).attr("data-sd") == "4" &&
      jQuery(this).attr("data-pd") == "12" &&
      jQuery(this).attr("data-oo").includes("1")
    ) {
      jQuery(this).removeClass("pink").addClass("gray");
    }
    // Sipariş durumu: 8 (İptal Edildi) - - Paketleme durumu Teslimat Sonrası Telefon Aramasına Gerek Yok 13
    // Ödeme onay 1 (bir) içeriyorsa
    // Bunlar iade olmalı çünkü ödeme yapılmış
    if (
      jQuery(this).attr("data-sd") == "8" &&
      jQuery(this).attr("data-pd") == "13" &&
      jQuery(this).attr("data-oo").includes("1")
    ) {
      jQuery(this).removeClass("pink").addClass("gray");
    }
    // Color gray ends

    // Color yellow begins
    // Paketleme durumu İptal Edildi 12
    // Ödeme onay 1 (bir) içermeyenler
    // Bunlar iade değildir çünkü ödeme yapılmamış
    if (
      !jQuery(this).attr("data-oo").includes("1") &&
      jQuery(this).attr("data-pd") == "12" &&
      !jQuery(this).hasClass("pink") &&
      !jQuery(this).hasClass("red") &&
      !jQuery(this).hasClass("gray")
    ) {
      jQuery(this).addClass("yellow");
    }
    // Color yellow ends

    // Color orange begins
    // Bundan önceki renkleri içermeyen
    // Ödeme onayı 1 (bir) içermeyen
    // This is like pink
    //
    if (
      !jQuery(this).attr("data-oo").includes("1") &&
      !jQuery(this).hasClass("pink") &&
      !jQuery(this).hasClass("red") &&
      !jQuery(this).hasClass("gray") &&
      !jQuery(this).hasClass("yellow")
    ) {
      jQuery(this).addClass("orange");
    }
    // Color orange ends

    // Color green begins
    // Ödeme onayı 1 (bir) olan
    // Bundan önceki renkleri içermeyen
    if (
      jQuery(this).attr("data-oo") == "1" &&
      !jQuery(this).hasClass("pink") &&
      !jQuery(this).hasClass("red") &&
      !jQuery(this).hasClass("gray") &&
      !jQuery(this).hasClass("orange") &&
      !jQuery(this).hasClass("yellow")
    ) {
      jQuery(this).addClass("green");
    }

    // Ödeme onayı 1 (bir) içeren
    // Sipariş durumu: 7 (Teslim Edildi)
    // Paketleme durumu: Teslimat Sonrası Telefonla Arandı 11 veya
    // Paketleme durumu: Teslimat Sonrası Telefon Aramasına Gerek Yok 13
    if (
      jQuery(this).attr("data-oo").includes("1") &&
      jQuery(this).attr("data-sd") == "7" &&
      (jQuery(this).attr("data-pd") == "11" ||
        jQuery(this).attr("data-pd") == "13") &&
      !jQuery(this).hasClass("green")
    ) {
      jQuery(this)
        .removeClass(["pink", "red", "gray", "orange", "yellow"])
        .addClass("green");
    }

    // Ödeme onayı 1 (bir) içeren
    // Sipariş durumu: 6 (Kargoya Verildi)
    // Paketleme durumu: Alıcıya Teslim Edildi (Kargo) 9
    if (
      jQuery(this).attr("data-oo").includes("1") &&
      jQuery(this).attr("data-sd") == "6" &&
      jQuery(this).attr("data-pd") == "9" &&
      !jQuery(this).hasClass("green")
    ) {
      jQuery(this)
        .removeClass(["pink", "red", "gray", "orange", "yellow"])
        .addClass("green");
    }

    // Ödeme onayı 1 (bir) içeren
    // Sipariş durumu: 0 (Siparişiniz Alındı)
    // Paketleme durumu: Alıcıya Teslim Edildi (Kargo) 9 veya
    // Paketleme durumu: Teslimat Sonrası Telefonla Arandı 11 veya
    // Paketleme durumu: Teslimat Sonrası Telefon Aramasına Gerek Yok 13
    if (
      jQuery(this).attr("data-oo").includes("1") &&
      jQuery(this).attr("data-sd") == "0" &&
      (jQuery(this).attr("data-pd") == "9" ||
        jQuery(this).attr("data-pd") == "11" ||
        jQuery(this).attr("data-pd") == "13") &&
      !jQuery(this).hasClass("green")
    ) {
      jQuery(this)
        .removeClass(["pink", "red", "gray", "orange", "yellow"])
        .addClass("green");
    }

    // Ödeme onayı 1 (bir) içeren
    // Sipariş durumu: 4 (Paketleniyor)
    // Paketleme durumu: Alıcıya Teslim Edildi (Kargo) 9 veya
    // Paketleme durumu: Teslimat Sonrası Telefonla Arandı 11 veya
    // Paketleme durumu: Teslimat Sonrası Telefon Aramasına Gerek Yok 13
    if (
      jQuery(this).attr("data-oo").includes("1") &&
      jQuery(this).attr("data-sd") == "4" &&
      (jQuery(this).attr("data-pd") == "9" ||
        jQuery(this).attr("data-pd") == "11" ||
        jQuery(this).attr("data-pd") == "13") &&
      !jQuery(this).hasClass("green")
    ) {
      jQuery(this)
        .removeClass(["pink", "red", "gray", "orange", "yellow"])
        .addClass("green");
    }

    // Ödeme onayı 1 (bir) içeren
    // Sipariş durumu: 6 (Kargoya Verildi)
    // Paketleme durumu: Teslimat Sonrası Telefonla Arandı 11
    if (
      jQuery(this).attr("data-oo").includes("1") &&
      jQuery(this).attr("data-sd") == "6" &&
      jQuery(this).attr("data-pd") == "11" &&
      !jQuery(this).hasClass("green")
    ) {
      jQuery(this)
        .removeClass(["pink", "red", "gray", "orange", "yellow"])
        .addClass("green");
    }

    // Ödeme onayı 1 (bir) içeren
    // Sipariş durumu: 6 (Kargoya Verildi)
    // Paketleme durumu: Teslimat Sonrası Telefon Aramasına Gerek Yok 13
    if (
      jQuery(this).attr("data-oo").includes("1") &&
      jQuery(this).attr("data-sd") == "6" &&
      jQuery(this).attr("data-pd") == "13" &&
      !jQuery(this).hasClass("green")
    ) {
      jQuery(this)
        .removeClass(["pink", "red", "gray", "orange", "yellow"])
        .addClass("green");
    }
    // Color green ends

    // Color black begins
    if (
      jQuery(this).attr("data-oo").includes("1") &&
      jQuery(this).attr("data-sd") == "13" &&
      jQuery(this).hasClass("green")
    ) {
      jQuery(this).removeClass("green").addClass("black");
    }
    // Color black ends
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

  totalFormatted = new Intl.NumberFormat("tr-TR", {
    style: "currency",
    currency: "TRY",
  }).format(total);
  html += "Total: " + totalFormatted + "<br/>";

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

  totalFormatted = new Intl.NumberFormat("tr-TR", {
    style: "currency",
    currency: "TRY",
  }).format(total);

  jQuery("#summary-two").html("Total: " + totalFormatted + "<br>Adet: " + adet);
}

function people(sortType = "ordercount") {
  const array = [];
  let caption = "";

  jQuery("#people").html("");

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

  if (sortType == "ordercount") {
    array.sort(function (a, b) {
      // adet desc, ad asc
      // return b.adet - a.adet || a.ad.localeCompare(b.ad);
      // adet desc, total desc
      return b.adet - a.adet || b.total - a.total;
    });
    caption =
      "Sipariş adedi azalan, sipariş tutar toplam azalan şekilde sıralı";
  }

  if (sortType == "total") {
    array.sort(function (a, b) {
      // adet desc, ad asc
      // return b.adet - a.adet || a.ad.localeCompare(b.ad);
      // adet desc, total desc
      return b.total - a.total;
    });
    caption = "Tutara göre azalan şekilde sıralı";
  }

  const templateHeader = `<div class="table-responsive">
  <table class="table table-striped table-hover table-bordered table-sm caption-top">
  <caption>${caption}
		</caption>
    <tr>
      <th>Üye</th>
      <th>Üye ID</th>
      <th>Sipariş Adet</th>
      <th>Sipariş Tutar (TL)</th>
    </tr>`;

  const templateFooter = `</table></div>`;

  html = templateHeader;

  for (var i = 0; i < array.length; i++) {
    sira = i + 1;
    totalFixed = roundNumber(array[i].total, 2);
    totalFormatted = new Intl.NumberFormat("tr-TR", {
      style: "currency",
      currency: "TRY",
    }).format(totalFixed);
    html += `<tr>
      <td>${array[i].ad.slice(0, -10)}</td>
      <td>${array[i].ad.slice(-10)}</td>
      <td class="text-end">${array[i].adet}</td>
      <td class="text-end">${totalFormatted}</td>
    </tr>`;
  }

  html += templateFooter;
  jQuery("#people").append(html);

  // alert(JSON.stringify(array, null, 4));
}

function showClass(classToShow) {
  jQuery(".siparis").show();
  jQuery(".siparis").each(function () {
    if (!jQuery(this).hasClass(classToShow)) {
      jQuery(this).hide();
    }
  });

  classToShowCount = jQuery("." + classToShow).length;
  totalCount = jQuery(".siparis").length;
  jQuery("#counter").html(
    classToShowCount +
      " / " +
      totalCount +
      " adet (%" +
      ((classToShowCount / totalCount) * 100).toFixed(2) +
      ")"
  );
}

function filterNames(value) {
  jQuery(".siparis").show();
  jQuery(".siparis").each(function () {
    if (!jQuery(this).find(".uye").html().includes(value)) {
      jQuery(this).hide();
    }
  });

  total = 0;
  jQuery('.siparis:not([style*="display: none"]).green').each(function () {
    total += parseFloat(jQuery(this).find(".total").html());
  });

  jQuery("#counter").html(
    jQuery('.siparis:not([style*="display: none"]).green').length +
      " adet" +
      " / " +
      jQuery('.siparis:not([style*="display: none"])').length +
      " adet - " +
      total.toFixed(2) +
      " TL."
  );
}

$(document).ready(function () {
  colorize();
  summarize_one();
  summarize_second();
  people();
  createButtons();

  jQuery("#counter").html(jQuery(".siparis").length + " adet");

  jQuery("#show-all").bind("click", function () {
    jQuery(".siparis").show();
    jQuery("#counter").html(jQuery(".siparis").length + " adet");
  });

  jQuery("#show-uncolored").bind("click", function () {
    jQuery(".siparis").show();

    jQuery(".siparis").each(function () {
      self = jQuery(this);
      if (
        self.hasClass("pink") ||
        self.hasClass("red") ||
        self.hasClass("gray") ||
        self.hasClass("yellow") ||
        self.hasClass("orange") ||
        self.hasClass("green") ||
        self.hasClass("black")
      ) {
        self.hide();
      }
    });

    jQuery("#counter").html(
      jQuery('.siparis:not([style*="display: none"])').length + " adet"
    );
  });
});
