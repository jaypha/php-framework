<?php
//----------------------------------------------------------------------------
// Bulk include file.
//----------------------------------------------------------------------------

require \Config\APP_ROOT."/vendor/autoload.php";

//---------------------------------------------------------

require "exceptions/DataIntegrityException.php";

require "jayponents-html/Button.php";
require "jayponents-html/ButtonRow.php";
require "jayponents-html/buttons.php";
require "jayponents-html/Dialog.php";
require "jayponents-html/Fieldset.php";
require "jayponents-html/Form.php";
require "jayponents-html/FormDialog.php";
require "jayponents-html/InlineButton.php";
require "jayponents-html/Table.php";

require "jayponents-html/JayphaList.php";
//require "jayponents-html/JayphaDatetime.php";
//require "jayponents-html/JayphaEditable.php";

require "jayponents-html/Widget.php";
require "jayponents-html/InputWidget.php";
require "jayponents-html/TextAreaWidget.php";
require "jayponents-html/SelectWidget.php";

require "jayponents-html/Ribbon.php";

require "icomoon/IcomoonIcon.php";
require "icomoon/IcomoonButtons.php";

require "Validator.php";

require "middleware/response-factories/ResponseFactory.php";
require "middleware/response-factories/NoResponseFactory.php";
require "middleware/response-factories/ConsoleResponseFactory.php";
require "middleware/response-factories/JsonResponseFactory.php";
require "middleware/response-factories/HtmlResponseFactory.php";
require "middleware/response-factories/LatteHtmlResponseFactory.php";

require "middleware/Middleware.php";
require "middleware/CmdLineParser.php";
require "middleware/Validation.php";
require "middleware/Database.php";
require "middleware/Timezone.php";
require "middleware/IEDetect.php";
require "middleware/ContentSecurityPolicy.php";
require "middleware/CsvOutput.php";
//require "middleware/HttpRange.php";

//require "streams/MetadataStream.php";
//require "streams/WrappedStream.php";
//require "streams/SlicedStream.php";
require "streams/PhpStream.php";
require "streams/StringInputStream.php";

require "storage/Entity.php";
require "storage/Tags.php";

require "auth/Login.php";
require "auth/User.php";


require "logging/MainLogger.php";
require "logging/StdoutLogger.php";
require "logging/functions.php";
require "logging/EchoLogger.php";
require "logging/DevLogger.php";
require "logging/NullLogger.php";
//require "logging/TextLogger.php";
require "logging/FileLogger.php";

require "io.php";
require "tokens.php";
require "gsm.php";
require "rnd.php";
require "http.php";
require "datetime.php";
require "arrays.php";
require "timing-safe.php";
require "csv.php";

require "middleware/Service.php";

//----------------------------------------------------------------------------
// Copyright (C) 2019 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
