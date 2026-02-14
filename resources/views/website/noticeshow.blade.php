<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Official Notice</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('/website/img/notice-watermark.jpg') no-repeat center center fixed;
            background-size: cover;
        }
        .notice-container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            border: 2px solid #000;
            background: url('/website/img/notice-watermark.jpg') no-repeat center center;
            background-size: cover;
        }
        .school-header {
            text-align: center;
            font-size: 20px;
            font-weight: bold;
        }
        .notice-title {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            text-decoration: underline;
        }
        .notice-content {
            font-size: 18px;
            margin-top: 20px;
        }
        .footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 40px;
        }
        .seal {
            width: 120px;
            height: 120px;
            background: url('/website/img/logo.jpeg') no-repeat center center;
            background-size: cover;
        }
        .signature img {
            width: 150px;
            height: auto;
        }
        .download-btn {
            display: block;
            width: 100%;
            margin-top: 20px;
            text-align: center;
        }
        @media (max-width: 576px) {
            .footer {
                flex-direction: column;
                text-align: center;
            }
            .seal {
                margin-bottom: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="notice-container shadow-lg p-4" id="noticeContent">
            <div class="school-header">Inspire Coaching Academy</div>
            <hr>
            <div class="notice-title">NOTICE</div>
            <p class="text-end"><strong>Date:</strong> {{ \Carbon\Carbon::now()->format('d M Y') }}</p>

            <div class="notice-content">
                <p><strong>Subject:</strong> <span id="noticeTitle">{{ $notification->title }}</span></p>
                <p id="noticeDescription">{{ $notification->description }}</p>
            </div>

            <div class="footer">
                <div class="seal"></div>
                <div class="signature">
                    <img src="/website/img/signature.png" alt="Principal Signature">
                    <p><strong>Principal</strong></p>
                </div>
            </div>
        </div>

        <button class="btn btn-primary download-btn" onclick="downloadPDF()">Download as PDF</button>
    </div>

    <script>
        function downloadPDF() {
            const { jsPDF } = window.jspdf;
            let doc = new jsPDF();

            // Get Blade values from the page
            let subject = document.getElementById("noticeTitle").innerText;
            let description = document.getElementById("noticeDescription").innerText;
            let date = new Date().toLocaleDateString();

            // Load watermark image
            let watermark = new Image();
            watermark.src = "/website/img/notice-watermark.jpg";

            watermark.onload = function() {
                doc.addImage(watermark, "JPEG", 0, 0, 210, 297); // A4 size

                // PDF Content
                doc.setFont("helvetica", "bold");
                doc.setFontSize(16);
                doc.text("Inspire Coaching Academy", 65, 20);

                doc.setFont("helvetica", "bold");
                doc.setFontSize(14);
                doc.text("NOTICE", 90, 30);

                doc.setFont("helvetica", "normal");
                doc.setFontSize(12);
                doc.text("Date: " + date, 150, 40);

                doc.setFont("helvetica", "bold");
                doc.text("Subject: " + subject, 20, 50);

                doc.setFont("helvetica", "normal");
                doc.text(description, 20, 60, { maxWidth: 160 });

                // Load Seal Image
                let seal = new Image();
                seal.src = "/website/img/logo.jpeg";

                seal.onload = function() {
                    doc.addImage(seal, "JPEG", 20, 120, 40, 40); // Seal image

                    // Load Signature Image
                    let signature = new Image();
                    signature.src = "/website/img/signature.png";

                    signature.onload = function() {
                        doc.addImage(signature, "PNG", 140, 120, 50, 20); // Signature image
                        doc.text("__________________", 140, 140);
                        doc.text("Principal", 160, 150);

                        // Save PDF
                        doc.save("notice.pdf");
                    };
                };
            };
        }
    </script>
</body>
</html>


