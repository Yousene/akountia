const userName = document.getElementById("name");
const formationName = document.getElementById("formation");
const lasession = document.getElementById("session");
const lasession2 = document.getElementById("session2");
const lacertifdate = document.getElementById("certifdate");
const submitBtn = document.getElementById("submitBtn");
// var check = document.getElementById("scales");

const { PDFDocument, rgb, degrees } = PDFLib;



const capitalize = (str, lower = false) =>
    (lower ? str.toLowerCase() : str).replace(/(?:^|\s|["'([{])+\S/g, (match) =>
        match.toUpperCase()
    );


submitBtn.addEventListener("click", () => {
    const val = capitalize(userName.value);
    const val2 = capitalize(formationName.value);
    const val3 = capitalize(lasession.value);
    const val4 = capitalize(lacertifdate.value);
    const val5 = capitalize(lasession2.value);
    //check if the text is empty or not
    if (val.trim() !== "" && val2.trim() !== "" && val3.trim() !== "" && val4.trim() !== "" && val5.trim() !== "" && userName.checkValidity() && lasession.checkValidity() && lasession2.checkValidity() && lacertifdate.checkValidity() && formationName.checkValidity()) {
        // console.log(val);
        generatePDF(val, val2, val3, val4, val5);
    } else {
        userName.reportValidity();
        formationName.reportValidity();
        lasession.reportValidity();
        lasession2.reportValidity();
        lacertifdate.reportValidity();
    }
});



const generatePDF = async (name, formation, session, session2, certifdate) => {
    const existingPdfBytes = await fetch("/assets/js/certif/certificate_afriqueacademy.pdf").then((res) =>
        res.arrayBuffer()
    );


    // Load a PDFDocument from the existing PDF bytes
    const pdfDoc = await PDFDocument.load(existingPdfBytes);
    pdfDoc.registerFontkit(fontkit);

    //get font
    const fontBytes = await fetch("/assets/js/certif/ArcaMajora3-Bold.otf").then((res) =>
        res.arrayBuffer()
    );




    // Embed our custom font in the document
    const ArcaMajora3 = await pdfDoc.embedFont(fontBytes);

    // Get the first page of the document
    const pages = pdfDoc.getPages();
    const firstPage = pages[0];

    // if (check.checked == true){
    //   const pngImageBytes = await fetch("./signature.png").then((res) => res.arrayBuffer());
    //   const signatureclient = await pdfDoc.embedPng(pngImageBytes);
    //   const pngDims = signatureclient.scale(0.5);

    //   firstPage.drawImage(signatureclient, {
    //     x: 500,
    //     y: 90,
    //     width: pngDims.width,
    //     height: pngDims.height,
    //   });
    // }



    const text = name;
    var textSize = 64;
    var textWidth = ArcaMajora3.widthOfTextAtSize(text, textSize);
    const textHeight = ArcaMajora3.heightAtSize(textSize);
    while (textWidth > 700) {
        textSize--;
        textWidth = ArcaMajora3.widthOfTextAtSize(text, textSize);
    }


    const text2 = formation;
    const ln = text2.length;
    var textSize2 = 24;
    var textWidth2 = ArcaMajora3.widthOfTextAtSize(text2, textSize2);

    while (textWidth2 > 700) {
        textSize2--;
        textWidth2 = ArcaMajora3.widthOfTextAtSize(text2, textSize2);
    }


    function formatDate(inputDate) {
        const originalDate = new Date(inputDate.value);
        const day = originalDate.getDate().toString().padStart(2, '0');
        const month = (originalDate.getMonth() + 1).toString().padStart(2, '0');  // Months are zero-based
        const year = originalDate.getFullYear();

        return `${day}/${month}/${year}`;
    }

    const formattedSession = formatDate(lasession);
    const formattedSession2 = formatDate(lasession2);
    const formattedCertifDate = formatDate(lacertifdate);

    console.log(formattedSession, formattedSession2, formattedCertifDate);


    session = "Du " + formattedSession + " Au " + formattedSession2;
    const text3 = session;
    const textSize3 = 16;
    const textWidth3 = ArcaMajora3.widthOfTextAtSize(text3, textSize3);
    const textHeight3 = ArcaMajora3.heightAtSize(textSize3);

    const text5 = session2;
    const textSize5 = 16;
    const textWidth5 = ArcaMajora3.widthOfTextAtSize(text5, textSize5);
    const textHeight5 = ArcaMajora3.heightAtSize(textSize5);

    const text4 = certifdate;
    const textSize4 = 10;
    const textWidth4 = ArcaMajora3.widthOfTextAtSize(text4, textSize4);
    const textHeight4 = ArcaMajora3.heightAtSize(textSize4);

    // Draw a string of text diagonally across the first page
    firstPage.drawText(name, {
        x: firstPage.getWidth() / 2 - textWidth / 2,
        y: 300,
        size: textSize,
        font: ArcaMajora3,
        color: rgb(0.4, 0.4, 0.4),
    });

    firstPage.drawText(formation, {
        x: firstPage.getWidth() / 2 - textWidth2 / 2,
        y: 225,
        size: textSize2,
        font: ArcaMajora3,
        color: rgb(0, 0.33, 0.44),
    });


    firstPage.drawText(session, {
        x: firstPage.getWidth() / 2 - textWidth3 / 2,
        y: 200,
        size: textSize3,
        font: ArcaMajora3,
        color: rgb(0.27, 0.67, 0.77),
    });



    certifdate = "À Casablanca, le " + formattedCertifDate;
    firstPage.drawText(certifdate, {
        x: 450,
        y: 170,
        size: textSize4,
        font: ArcaMajora3,
        color: rgb(0.6, 0.6, 0.6),
    });








    // Serialize the PDFDocument to bytes (a Uint8Array)
    const pdfBytes = await pdfDoc.save();
    console.log("Done creating");

    // this was for creating uri and showing in iframe

    // const pdfDataUri = await pdfDoc.saveAsBase64({ dataUri: true });
    // document.getElementById("pdf").src = pdfDataUri;

    var file = new File(
        [pdfBytes],
        name + " - " + formation + ".pdf",
        {
            type: "application/pdf;charset=utf-8",
        }
    );
    saveAs(file);
};

// init();
