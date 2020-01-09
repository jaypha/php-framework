<?php
//----------------------------------------------------------------------------
// Bulk include file.
//----------------------------------------------------------------------------

require "exceptions/DataIntegrityException.php";
require "exceptions/DeprecatedException.php";

require "validation/require.php";

require "io.php";
require "tokens.php";
require "gsm.php";
require "rnd.php";
require "http.php";
require "datetime.php";
require "datetime-mysql.php";
require "arrays.php";
require "timing-safe.php";
require "csv.php";
require "json-functions.php";

require "Steps.php";

require "PdfDocument.php";
require "CsvDocument.php";

require "jslib/app-js.php";

require "logging/functions.php";
require "logging/DevLogger.php";
require "logging/EchoLogger.php";
require "logging/FileLogger.php";
require "logging/NullLogger.php";
require "logging/ProductionLogger.php";
require "logging/StreamLogger.php";
//require "logging/TextLogger.php";

require "storage/Entity.php";
require "storage/Tags.php";
require "storage/DbDag.php";

require "latte/IncludePathFileLoader.php";
require "middleware/Middleware.php";
require "middleware/Service.php";

require "middleware/DetectUserAgent.php";
require "middleware/SetContentSecurityPolicy.php";
require "middleware/PdfOutput.php";
require "middleware/CsvOutput.php";
require "middleware/JsonOutput.php";
require "middleware/ImageOutput.php";
require "middleware/UseMysql.php";
require "middleware/UseLatteEngine.php";
require "middleware/SetTimezone.php";
require "middleware/ValidateId.php";

require "jayponents-html/DocReadyScript.php";

require "jayponents-html/JayphaDocument.php";

require "jayponents-html/buttons.php";
require "jayponents-html/Button.php";
require "jayponents-html/ButtonRow.php";
require "jayponents-html/InlineButton.php";
require "jayponents-html/Ribbon.php";

require "jayponents-html/Control.php";
require "jayponents-html/ControlGroup.php";
require "jayponents-html/InputControl.php";
require "jayponents-html/DateControl.php";
require "jayponents-html/TextControl.php";
require "jayponents-html/TextAreaControl.php";
require "jayponents-html/SelectControl.php";
require "jayponents-html/RadioGroupControl.php";
require "jayponents-html/CheckboxControl.php";

require "jayponents-html/JayphaList.php";
require "jayponents-html/JayphaEditable.php";
require "jayponents-html/JayphaEnum.php";

require "jayponents-html/Form.php";
require "jayponents-html/Dialog.php";

require "icomoon/IcomoonIcon.php";
require "icomoon/IcomoonButtons.php";

require "auth/Login.php";
require "auth/User.php";

require "error-handling.php";

//----------------------------------------------------------------------------
// Copyright (C) 2019 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
