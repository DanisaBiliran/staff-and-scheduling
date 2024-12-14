(function (factory) {
  if (typeof define === "function" && define.amd) {
    // AMD
    define(["jquery", "datatables.net"], function ($) {
      return factory($, window, document);
    });
  } else if (typeof exports === "object") {
    // CommonJS
    var jq = require("jquery");
    var cjsRequires = function (root, $) {
      if (!$.fn.dataTable) {
        require("datatables.net")(root, $);
      }
    };

    if (typeof window === "undefined") {
      module.exports = function (root, $) {
        if (!root) {
          root = window;
        }

        if (!$) {
          $ = jq(root);
        }

        cjsRequires(root, $);
        return factory($, root, root.document);
      };
    } else {
      cjsRequires(window, jq);
      module.exports = factory(jq, window, window.document);
    }
  } else {
    factory(jQuery, window, document);
  }
})(function ($, window, document) {
  "use strict";
  var DataTable = $.fn.dataTable;

  /*
   * This is a tech preview of Tailwind CSS integration with DataTables.
   */

  // Set the defaults for DataTables initialisation
  $.extend(true, DataTable.defaults, {
    renderer: "tailwindcss",
  });

  // Default class modification
  $.extend(true, DataTable.ext.classes, {
    search: {
      input: "input input-bordered ml-2 input-sm",
    },
    length: {
      select: "select select-bordered select-sm mr-5",
    },
    processing: {
      container: "dt-processing",
    },
    paging: {
      active: "font-semibold btn btn-primary",
      button:
        "relative btn join-item inline-flex justify-center items-center space-x-2 border px-4 py-2 -mr-px leading-6 hover:z-10 focus:z-10 active:z-10",
      container: "join",
    },
    table: "dataTable text-sm align-middle whitespace-nowrap",
    thead: {
      row: "border-0 hover:border-0",
      cell: "px-3 py-4 font-semibold text-left",
    },
    tbody: {
      cell: "p-3",
    },
    tfoot: {
      cell: "p-3 text-left",
    },
  });

  DataTable.ext.renderer.pagingButton.tailwindcss = function (
    settings,
    buttonType,
    content,
    active,
    disabled
  ) {
    var classes = settings.oClasses.paging;
    var btnClasses = [classes.button];

    btnClasses.push(active ? classes.active : classes.notActive);
    btnClasses.push(disabled ? classes.notEnabled : classes.enabled);

    var a = $("<a>", {
      href: disabled ? null : "#",
      class: btnClasses.join(" "),
    }).html(content);

    return {
      display: a,
      clicker: a,
    };
  };

  DataTable.ext.renderer.pagingContainer.tailwindcss = function (
    settings,
    buttonEls
  ) {
    var classes = settings.oClasses.paging;

    buttonEls[0].addClass(classes.first);
    buttonEls[buttonEls.length - 1].addClass(classes.last);

    return $("<ul/>").addClass("pagination").append(buttonEls);
  };

  DataTable.ext.renderer.layout.tailwindcss = function (
    settings,
    container,
    items
  ) {
    var row = $("<div/>", {
      class: items.full
        ? "grid grid-cols-1 gap-4 mb-4"
        : "flex justify-between items-center gap-4 mb-4",
    }).appendTo(container);

    $.each(items, function (key, val) {
      var klass;

      // Apply start / end (left / right when ltr) margins
      if (val.table) {
        klass = "col-span-2";
      } else if (key === "start") {
        klass = "justify-self-start";
      } else if (key === "end") {
        klass = "col-span-2 justify-self-end";
      } else {
        klass = "col-span-2 justify-self-center";
      }

      $("<div/>", {
        id: val.id || null,
        class: klass + " " + (val.className || ""),
      })
        .append(val.contents)
        .appendTo(row);
    });
  };

  return DataTable;
});
