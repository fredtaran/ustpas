<!DOCTYPE html>
<html>
    <head>
        <title>Generate Laravel TCPDF by codeanddeploy.com</title>
        <style>
            table {
                border-collapse: collapse;
            }

            table, th, td {
                /* border: 1px solid black; */
                text-align: center;
                vertical-align: middle;
            }

            p {
                font-family: Arial, Helvetica, sans-serif;
            }

            #subject_table {
                margin-top: 15px;
                width: 100%;
            }

            #subject_table, #subject_table th, #subject_table td {
                border: 1px solid black;
                text-align: center;
                vertical-align: middle;
                font-size: 14px;
            }

            #note_tbl, #note_tbl th, #note_tbl td {
                font-size: 14px;
            }

            li {
                text-align: left;
            }
        </style>
    </head>
    <body>
        <table>
            <thead>
                <tr>
                    <th rowspan="10" style="vertical-align: baseline;">
                        <img src="../public/img/ustp-logo.png" alt="USTP Logo" style="width: 80px; height: auto;">
                    </th>

                    <th colspan="3" style="font-size: 12px;">
                        Republic of the Philippines
                    </th>
                </tr>

                <tr>
                    <th colspan="3" style="font-size: 16px; padding-left: 20px;">UNIVERSITY OF SCIENCE AND TECHNOLOGY OF SOUTHERN PHILIPPINES</th>
                </tr>

                <tr>
                    <th colspan="3" style="font-size: 12px;">Cagayan de Oro City</th>
                </tr>

                <tr>
                    <th colspan="2" style="font-size: 12px;">&nbsp;</th>
                    <th style="font-size: 11px; font-style: italic; text-align: right;">RF 20</th>
                </tr>

                <tr>
                    <th colspan="3" style="font-size: 13px;">Office of the University Registrar</th>
                </tr>

                <tr>
                    <th colspan="3" style="font-size: 13px;">&nbsp;</th>
                </tr>

                <tr>
                    <th colspan="3" style="padding: 0; margin: 0;">
                        <p style="font-size: 13px; padding: 0; margin: 0;">APPLICATION FOR ACCREDITATION OF SUBJECTS</p>
                    </th>
                </tr>

                <tr>
                    <th colspan="3" style="padding: 0; margin: 0;">
                        <p style="font-size: 13px; padding: 0; margin: 0;">TAKEN IN OTHER COLLEGES/UNIVERSITIES</p>
                    </th>
                </tr>
                
                <tr>
                    <th colspan="3" style="padding: 0; margin: 0;">
                        <p style="font-size: 13px; padding: 0; margin: 0;">(College Level)</p>
                    </th>
                </tr>

                <tr>
                    <td colspan="3" style="padding: 0; margin: 0;">
                        <p style="font-size: 13px; padding: 0; margin: 0;">_____ Semester/Summer, SY _________</p>
                    </td>
                </tr>
            </thead>
        </table>

        <table style="margin-top: 25px;">
            <tbody>
                <tr>
                    <td style="text-align: left; padding-right: 10px;">Name ______________________________________</td>
                    <td style="text-align: left;">Student ID No. _____________________________</td>
                </tr>

                <tr>
                    <td style="text-align: left; padding-right: 10px;">Course & Year _______________________________</td>
                    <td style="text-align: left;">Major (if any) ______________________________</td>
                </tr>

                <tr>
                    <td colspan="2" style="text-align: left;">Name of School last attended _______________________________________________________________</td>
                </tr>

                <tr>
                    <td style="text-align: left; padding-right: 10px;">Previous Course ______________________________</td>
                    <td style="text-align: left;">Period of Attendance ________________________</td>
                </tr>
            </tbody>
        </table>

        <table id="subject_table">
            <thead>
                <tr>
                    <th colspan="3">Subjects to be Accredited</th>
                    <th rowspan="2" style="width: 100px; padding: 0 10px;">Accredited to (Subject Code & Descriptive Title)</th>
                    <th rowspan="2" style="width: 50px; padding: 0 10px;">Remarks</th>
                    <th rowspan="2" style="width: 140px; padding: 0 10px;">Name & Signature of Program/Area Chairperson</th>
                </tr>
                
                <tr>
                    <th style="width: 50px; padding: 0 10px;">Subject Code</th>
                    <th style="width: 150px; padding: 0 10px;">Descriptive Title</th>
                    <th style="width: 50px; padding: 0 10px;">Units</th>
                </tr>
            </thead>
            <tbody>
                @for ($i = 1; $i <= 13; $i++)
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                @endfor
            </tbody>
        </table>

        <table style="width: 100%; margin-top: 15px;">
            <tbody>
                <tr>
                    <td style="width: 50%">&nbsp;</td>
                    <td style="width: 50%">___________________________</td>
                </tr>

                <tr>
                    <td style="width: 50%">&nbsp;</td>
                    <td style="width: 50%">Student's Signature</td>
                </tr>

                <tr>
                    <td style="width: 50%">&nbsp;</td>
                    <td style="width: 50%">&nbsp;</td>
                </tr>

                <tr>
                    <td style="width: 50%">Recommending Approval: </td>
                    <td style="width: 50%">Approved:</td>
                </tr>

                <tr>
                    <td style="width: 50%">&nbsp;</td>
                    <td style="width: 50%">&nbsp;</td>
                </tr>

                <tr>
                    <td style="width: 50%">___________________________</td>
                    <td style="width: 50%">___________________________</td>
                </tr>

                <tr>
                    <td style="width: 50%">Signature over Printed Name</td>
                    <td style="width: 50%">Signature over Printed Name of Dean</td>
                </tr>

                <tr>
                    <td style="width: 50%">of Program Chairperson</td>
                    <td style="width: 50%">&nbsp;</td>
                </tr>

                <tr>
                    <td style="width: 50%">&nbsp;</td>
                    <td style="width: 50%">Date: _____________________</td>
                </tr>
            </tbody>
        </table>

        <div style="width: 100%; border: 1px solid black; margin-top: 15px; padding: 0 5px;">
            <table id="note_tbl">
                <tbody>
                    <tr>
                        <td style="font-weight: bold; vertical-align: baseline;">Note: </td>
                        <td>
                            <ul style="">
                                <li>Please attach <span style="font-style: italic">Transcript of Records</span>.</li>
                                <li>Accomplish this form in duplicate (1 copy for Registrar's Office & the other copy is retained by the student).</li>
                                <li>The subjects for accreditation will only be officially accredited once the previous College/University provides USTP the official transcript of records with the remarks: <span style="font-style: italic">Granted Transfer Credential, copy for USTP</span>.</li>
                            </ul>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <hr style="border: 1px dashed black;">
        <p style="font-weight: bold; font-size: 14px; text-align: center;">To be filled out by the Registrar staff</p>

        <table style="width: 100%">
            <tbody>
                <tr>
                    <td style="width: 75%">Accreditation form received by: _____________________________</td>
                    <td style="width: 25%">Date: _______________</td>
                </tr>

                <tr>
                    <td style="width: 75%; padding-left: 12em;">Signature over Printed Name</td>
                    <td style="width: 25%">&nbsp;</td>
                </tr>
            </tbody>
        </table>
    </body>
</html>