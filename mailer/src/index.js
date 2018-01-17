import {readFileSync} from 'fs';
import {parse} from 'ini';
import {resolve} from 'path';
import express from "express";
import bodyParser from "body-parser";
import nodemailer from "nodemailer";

import cors from "cors";


const app = express();
const PORT = 9090;
const SLEEP_TIME = 1500;

app.use(bodyParser.json());
app.use(cors());

const config = parse(readFileSync(resolve(__dirname, '../../application/configs/application.ini'), 'utf-8'));

const sysEmail = `${config['production']['system.email.name']} <${config['production']['system.email.address']}>`;

const transport = nodemailer.createTransport({
	host: config['production']['resources.mail.transport.host'],
	port: config['production']['resources.mail.transport.port'],
	secure: config['production']['resources.mail.transport.secure'],
	greetingTimeout: 60000,
	auth: {
		user: config['production']['resources.mail.transport.username'],
		pass: config['production']['resources.mail.transport.password']
	}
});


const sleep = ms => new Promise(resolve => setTimeout(resolve, ms));

const sendArtisanMail = async ({email_artisan, nom_artisan}, ref) => {
	if (!email_artisan) return null;
	
	const options = {
		from: sysEmail,
		to: email_artisan,
		subject: 'Nouvelle demande de devis',
		html: `
        <div style="width: 650px; margin: 80px auto;">
            <div style="text-align: center; padding: 10px;"><img src="http://www.webonline2018.com/resources_fo_ehcg/img/company_logo_1.jpg" /></div>
            <h1 style="background-color:#0184c2;padding: 50px;color:#fff;text-align: center;">Une nouvelle demande de devis a été mise en ligne</h1>
            <p>Bonjour ${nom_artisan},</p>
            <p>Nous vous informons qu'une nouvelle demande de devis concernant votre activité et votre zone d'intervention a été publiée dans la plateforme.</p>
            <p>Vous pouvez la consulter dans votre espace pro.</p>
            <h1>Demande N°: ${ref}</h1>
            <p> A très bientôt</p>
            <p>L'équipe <a href="http://mister-devis.com">mister-devis.com</a></p>
        </div>
        `
	};
	transport.sendMail(options, err => {
		if (err) throw err;
		html: `
        <div style="width: 650px; margin: 80px auto;">
            <div style="text-align: center; padding: 10px;"><img src="http://www.webonline2018.com/resources_fo_ehcg/img/company_logo_1.jpg" /></div>
            <h1 style="background-color:#0184c2;padding: 50px;color:#fff;text-align: center;">Une nouvelle demande de devis a été mise en ligne</h1>
            <p>Bonjour ${nom_artisan},</p>
            <p>Nous vous informons qu'une nouvelle demande de devis concernant votre activité et votre zone d'intervention a été publiée dans la plateforme.</p>
            <p>Vous pouvez la consulter dans votre espace pro.</p>
            <h1>Demande N°: ${ref}</h1>
            <p> A très bientôt</p>
            <p>L'équipe <a href="http://mister-devis.com">mister-devis.com</a></p>
        </div>
        `
	});
};

const sendParticulierMail = async ({email_particulier, nom_particulier}, ref) => {
	if (!email_particulier) return null;
	
	const options = {
		from: sysEmail,
		to: email_particulier,
		subject: 'Confirmation de votre demande de devis',
		html: `
				<div style="width: 650px; margin: 80px auto;">
					<div style="text-align: center; padding: 10px;"><img src="http://www.webonline2018.com/resources_fo_ehcg/img/company_logo_1.jpg" /></div>
					<h1 style="background-color:#0184c2;padding: 50px;color:#fff;text-align: center;">Confirmation de votre demande de devis</h1>
					<p>Bonjour ${nom_particulier},</p>
					<p>Nous vous confirmons la réception de votre demande de devis.</p>
					<p>Prochainement un de nos conseillers vous contactera afin de recueillir l'ensemble des informations concernant votre projet.</p>
					<h1>Demande N°: ${ref}</h1>
					<p> A très bientôt</p>
					<p>L'équipe <a href="http://mister-devis.com">mister-devis.com</a></p>
				</div>
        `
	};
	transport.sendMail(options, err => {
		if (err) throw err;
	});
};

const sendOpMail = async ({email_user, firstname_user}, url, ref) => {
	if (!email_user) return null;
	
	const options = {
		from: sysEmail,
		to: email_user,
		subject: 'Confirmation de votre demande de devis',
		html: `
				<div style="width: 650px; margin: 80px auto;">
					<div style="text-align: center; padding: 10px;"><img src="http://www.webonline2018.com/resources_fo_ehcg/img/company_logo_1.jpg" /></div>
					<h1 style="background-color:#0184c2;padding: 50px;color:#fff;text-align: center;">Confirmation de votre demande de devis</h1>
					<p>Bonjour ${firstname_user},</p>
					<p>Nous vous confirmons la réception de votre demande de devis.</p>
					<p>Prochainement un de nos conseillers vous contactera afin de recueillir l'ensemble des informations concernant votre projet.</p>
					<h1>Demande N°: ${ref}</h1>
					<p><a href="${url}">Cliquez ici pour accèder au backoffice</a></p>
					<p>A très bientôt</p>
					<p>L'équipe <a href="http://mister-devis.com">mister-devis.com</a></p>
				</div>
        `
	};
	transport.sendMail(options, err => {
		if (err) throw err;
	});
};

app.get('/', (req, res) => {
	console.log('ok');
	return res.status(403).send('<h1 style="font-size:46px; text-align: center">403 Forbidden</h1><hr />');
});


app.post('/', async (req, res) => {
	
	const {artisans, particuliers, ops, ref, url} = req.body;
	let i = 0, j = 0, k = 0;
	
	res.end(); // send back empty response
	
	// if there are particulier recepients we loop thru them
	if (particuliers && particuliers.length) {
		while (true) {
			if (i >= particuliers.length)
				break;
			
			
			const particulier = particuliers[i];
			console.log(particulier);
			
			if (typeof particulier !== "undefined") {
				if (particulier['email_particulier']) {
					await sleep(SLEEP_TIME); // waiting a bit before sending the next email
					sendParticulierMail(particulier, ref)
						.then(() => console.log(`${particulier['email_particulier']} particulier OK`))
						.catch(err => console.error(err));
				}
			}
			i++;
		}
	}
	
	// if there are artisan recepients we loop thru them
	if (artisans && artisans.length) {
		while (true) {
			if (j >= artisans.length)
				break;
			
			const artisan = artisans[j];
			
			if (typeof artisan !== "undefined") {
				if (artisan['email_artisan']) {
					await sleep(SLEEP_TIME); // waiting a bit before sending the next email
					sendArtisanMail(artisan, ref)
						.then(() => console.log(`${artisan['email_artisan']} artisan OK`))
						.catch(err => console.error(err));
				}
			}
			j++;
		}
	}
	
	
	// if there are operators recepients we loop thru them
	if (ops && ops.length) {
		while (true) {
			if (j >= ops.length)
				break;
			
			const op = ops[j];
			
			if (typeof op !== "undefined") {
				if (op['email_user']) {
					await sleep(SLEEP_TIME); // waiting a bit before sending the next email
					sendOpMail(op, url, ref)
						.then(() => console.log(`${op['email_user']} User OK`))
						.catch(err => console.error(err));
				}
			}
			j++;
		}
	}
	
});

app.listen(PORT, () => console.log(`Server running on port ${PORT}`));
