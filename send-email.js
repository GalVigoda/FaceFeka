
var nodemailer = require('nodemailer');

var transporter = nodemailer.createTransport({
  service: 'gmail',
  auth: {
    user: 'flappybirdinvitation@gmail.com',
    pass: 'naorgal123'
  }
});

var mailOptions = {
  from: 'flappy2323birdinvitation@gmail.com',
  to: 'galvigoda@gmail.com',
  subject: 'Sending Email using Node.js',
  text: '  ',
  html: '<h2>come play with your friend :)</h2><h3>http://www.ynet.co.il</h3>'
  
};

transporter.sendMail(mailOptions, function(error, info){
  if (error) {
    console.log(error);
  } else {
    console.log('Email sent: ' + info.response);
  }
});
