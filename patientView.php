<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/medicalHistory.css">
    <title>Medical History</title>
</head>
<body>
    <br><br><br><br>
        <!-- enclosed everything in a table for easy sorting chuchu -->
        <table id="patient-medical">
            <tr>
                <td id="medical-history-title">Medical History</td>
                <td class="none" colspan="2"></td>
                
            </tr>

            <tr>
                <td colspan= "2" rowspan="4" id="med-history-details">
                    <b>Allergies: </b>
                    <div>
                        <!-- data --><br><br><br>a
                    </div>

                    <b>Medications: </b> 
                    <div>
                        <!-- data --><br><br><br>a
                    </div>

                    <b>Signs and symptoms: </b>
                    <div>
                        <!-- data --><br><br><br>a
                    </div>

                    <b>Past medical history: </b>
                    <div>
                        <!-- data --><br><br><br>a 
                    </div>

                    <b>Events leading up to the current illness or injury: </b> 
                    <div>
                        <!-- data --><br><br><br>a
                    </div>

                    <br><br>
                </td>
                <td id="physician">
                    <p> <b>Physician: </b> </p>
                    <p>jhbjh <!-- Physician Name --></p>
                </td>    
            </tr>

            <tr>
                <td class="none" id="below"></td>
            </tr>
                
            <tr>
                <td id="discharge-details">
                    <p> <b>Discharge Details:</b> </p>
                    <p>jhbjh <!-- discharge details --></p>
                </td>
            </tr>

            <tr class="none">
                <td class="none" id="below"></td>
            </tr>
        </table>
</body>
</html>

<style>
	body{
    background-color: #F5F6FA;
    font-family: Arial, Helvetica, sans-serif;
    }

    /* CELLS USED AS SPACES AND NOTHING MORE */
    .none{
    border: none; 
    }

    /* CELL/SPACE BELOW DISCHARGE DETAILS */
    #below{
        height: 30px;
    }

    /* TABLE */
    #patient-medical{
        width: 80%;
        height: auto;
        margin: auto;
        border-spacing: 15px 0; 

    }

    /* COLORED TITLE ABOVE */
    #medical-history-title{
        width: 25%;
        background-color: #752BDF;
        color: white;
        border-radius: 10px 90px 0 0;
        padding: 5px 10px 5px 10px;
    }

    /* DETAILS */
    #med-history-details{
        border: 2px solid #752BDF;
        width: 60%;
        vertical-align: top;
        padding: 5px 10px 5px 10px;
        word-wrap: break-word;
        overflow-wrap: break-word;
    }

    #med-history-details div{
        width: 100%;
        height: auto;
        margin-bottom: 15px;

        border-radius: 5px;
        background-color: rgb(222, 217, 217);
    }

    /* PHYSICIAN NAME */
    #physician{
        border: 2px solid #752BDF;
        vertical-align: top;
        padding: 5px 10px 5px 10px;
        word-wrap: break-word;
        overflow-wrap: break-word;
    }

    /* DISCHARGE DETAILS */
    #discharge-details{
        border: 2px solid #752BDF;
        vertical-align: top;
        padding: 5px 10px 5px 10px;
        word-wrap: break-word;
        overflow-wrap: break-word;
    }
</style>