import React, { useState } from "react";
import styled from "styled-components";
import { MdRestaurant } from "react-icons/md";
import { BsCalendar3 } from "react-icons/bs";
import HeureResa from "./HeureResa";
import axios from "axios";

const Reservation = (props) => {
  const date = props.date;
  const semaine = props.semaine;
  const jours = {
    1: "Lundi",
    2: "Mardi",
    3: "Mercredi",
    4: "Jeudi",
    5: "Vendredi",
    6: "Samedi",
    0: "Dimanche",
  };

  //useStateInit
  const [emailResa, setEmailResa] = useState(props.userMail);
  const [numResa, setNumResa] = useState(props.userNum);
  const [nomResa, setNomResa] = useState(props.userNom);
  const [allergeneResa, setAllergeneResa] = useState(props.userAllergene);
  const [commentaireResa, setCommentaireResa] = useState("");
  const [couvertsResa, setCouvertsResa] = useState(props.userCouvert);
  const [dateResa, setDateResa] = useState("");
  const [heureResa, setHeureResa] = useState("");
  const [HorairesMidi, setHorairesMidi] = useState();
  const [HorairesSoir, setHorairesSoir] = useState();
  const [toast, setToast] = useState("");

  function limiteHoraire(semaine, jour) {
    let test = {
      Midi: {
        Ouverture: null,
        Fermeture: null,
      },
      Soir: {
        Ouverture: null,
        Fermeture: null,
      },
    };
    switch (jour) {
      case "Lundi":
        if (semaine.Lundi.open) {
          if (semaine.Lundi.open_midi) {
            test.Midi.Ouverture = new Date(semaine.Lundi.open_midi.date);
            test.Midi.Fermeture = new Date(semaine.Lundi.close_midi.date);
          } else {
            test.Midi = null;
          }
          if (semaine.Lundi.open_soir) {
            test.Soir.Ouverture = new Date(semaine.Lundi.open_soir.date);
            test.Soir.Fermeture = new Date(semaine.Lundi.close_soir.date);
          } else {
            test.Soir = null;
          }

          break;
        } else {
          test = null;
          break;
        }
      case "Mardi":
        if (semaine.Mardi.open) {
          if (semaine.Mardi.open_midi) {
            test.Midi.Ouverture = new Date(semaine.Mardi.open_midi.date);
            test.Midi.Fermeture = new Date(semaine.Mardi.close_midi.date);
          } else {
            test.Midi = null;
          }
          if (semaine.Mardi.open_soir) {
            test.Soir.Ouverture = new Date(semaine.Mardi.open_soir.date);
            test.Soir.Fermeture = new Date(semaine.Mardi.close_soir.date);
          } else {
            test.Soir = null;
          }

          break;
        } else {
          test = null;
          break;
        }
      case "Mercredi":
        if (semaine.Mercredi.open) {
          if (semaine.Mercredi.open_midi) {
            test.Midi.Ouverture = new Date(semaine.Mercredi.open_midi.date);
            test.Midi.Fermeture = new Date(semaine.Mercredi.close_midi.date);
          } else {
            test.Midi = null;
          }
          if (semaine.Mercredi.open_soir) {
            test.Soir.Ouverture = new Date(semaine.Mercredi.open_soir.date);
            test.Soir.Fermeture = new Date(semaine.Mercredi.close_soir.date);
          } else {
            test.Soir = null;
          }

          break;
        } else {
          test = null;
          break;
        }
      case "Jeudi":
        if (semaine.Jeudi.open) {
          if (semaine.Jeudi.open_midi) {
            test.Midi.Ouverture = new Date(semaine.Jeudi.open_midi.date);
            test.Midi.Fermeture = new Date(semaine.Jeudi.close_midi.date);
          } else {
            test.Midi = null;
          }
          if (semaine.Jeudi.open_soir) {
            test.Soir.Ouverture = new Date(semaine.Jeudi.open_soir.date);
            test.Soir.Fermeture = new Date(semaine.Jeudi.close_soir.date);
          } else {
            test.Soir = null;
          }

          break;
        } else {
          test = null;
          break;
        }
      case "Vendredi":
        if (semaine.Vendredi.open) {
          if (semaine.Vendredi.open_midi) {
            test.Midi.Ouverture = new Date(semaine.Vendredi.open_midi.date);
            test.Midi.Fermeture = new Date(semaine.Vendredi.close_midi.date);
          } else {
            test.Midi = null;
          }
          if (semaine.Vendredi.open_soir) {
            test.Soir.Ouverture = new Date(semaine.Vendredi.open_soir.date);
            test.Soir.Fermeture = new Date(semaine.Vendredi.close_soir.date);
          } else {
            test.Soir = null;
          }

          break;
        } else {
          test = null;
          break;
        }
      case "Samedi":
        if (semaine.Samedi.open) {
          if (semaine.Samedi.open_midi) {
            test.Midi.Ouverture = new Date(semaine.Samedi.open_midi.date);
            test.Midi.Fermeture = new Date(semaine.Samedi.close_midi.date);
          } else {
            test.Midi = null;
          }
          if (semaine.Samedi.open_soir) {
            test.Soir.Ouverture = new Date(semaine.Samedi.open_soir.date);
            test.Soir.Fermeture = new Date(semaine.Samedi.close_soir.date);
          } else {
            test.Soir = null;
          }

          break;
        } else {
          test = null;
          break;
        }
      default:
        if (semaine.Dimanche.open) {
          if (semaine.Dimanche.open_midi) {
            test.Midi.Ouverture = new Date(semaine.Dimanche.open_midi.date);
            test.Midi.Fermeture = new Date(semaine.Dimanche.close_midi.date);
          } else {
            test.Midi = null;
          }
          if (semaine.Dimanche.open_soir) {
            test.Soir.Ouverture = new Date(semaine.Dimanche.open_soir.date);
            test.Soir.Fermeture = new Date(semaine.Dimanche.close_soir.date);
          } else {
            test.Soir = null;
          }

          break;
        } else {
          test = null;
          break;
        }
    }
    return test;
  }

  function possibleChoix(test) {
    if (test !== null) {
      if (test.Midi !== null) {
        var possibilité = new Date(test.Midi.Ouverture);
        var tab =[possibilité.getHours() +
          ":" +
          (possibilité.getMinutes() < 10 ? "0" : "") +
          possibilité.getMinutes()]
        while (possibilité.getTime() < (test.Midi.Fermeture.getTime()-60*60000)) {
          possibilité = new Date(possibilité.getTime() + 15 * 60000);
          tab.push(possibilité.getHours() +
          ":" +
          (possibilité.getMinutes() < 10 ? "0" : "") +
          possibilité.getMinutes())
        }
        setHorairesMidi(tab);
      } else {
        setHorairesMidi("");
      }
      if (test.Soir !== null) {
        var possibilité = new Date(test.Soir.Ouverture);
        var tab =[possibilité.getHours() +
          ":" +
          (possibilité.getMinutes() < 10 ? "0" : "") +
          possibilité.getMinutes()]
        while (possibilité.getTime() < (test.Soir.Fermeture.getTime()-60*60000)) {
          possibilité = new Date(possibilité.getTime() + 15 * 60000);
          tab.push(possibilité.getHours() +
          ":" +
          (possibilité.getMinutes() < 10 ? "0" : "") +
          possibilité.getMinutes())
          ;
        }
        setHorairesSoir(tab);
      } else {
        setHorairesSoir("");
      }
    } else {
      setHorairesMidi("");
      setHorairesSoir("");
    }
  }

  let testhoraire = (e) => {
    const test = new Date(e.target.value);
    console.log(jours[test.getDay()]);
    setDateResa(test);
    let futurChoix = limiteHoraire(semaine, jours[test.getDay()]);
    console.log(futurChoix);
    possibleChoix(futurChoix);
  };

  //handle
  const handleSubmit = (e) => {
    e.preventDefault();
    let formulaire;
    if (props.userMail){
      formulaire = {
        Email: emailResa,
        Num: numResa,
        Nom: nomResa,
        Allergene: allergeneResa,
        Commentaire: commentaireResa,
        Couverts: couvertsResa,
        Date: dateResa,
        Heure: heureResa,
        User: props.userMail,
      };
    }
    else{
      formulaire = {
        Email: emailResa,
        Num: numResa,
        Nom: nomResa,
        Allergene: allergeneResa,
        Commentaire: commentaireResa,
        Couverts: couvertsResa,
        Date: dateResa,
        Heure: heureResa,
      };
    }
    console.log(formulaire);
    axios
      .post("/addResa", formulaire)
      .then(function (response) {
        console.log(response.data);
        setToast(true);
      })
      .catch(function (error) {
        console.log(error);
        setToast(false);
      });
  };

  const handleEmailInput = (e) => setEmailResa(e.target.value);
  const handleNumInput = (e) => setNumResa(e.target.value);
  const handleNomInput = (e) => setNomResa(e.target.value);
  const handleAllergeneInput = (e) => setAllergeneResa(e.target.value);
  const handleCommentaireInput = (e) => setCommentaireResa(e.target.value);
  const handleCouvertSelect = (e) => setCouvertsResa(e.target.value);

  return (
    <Wrapper>
      <h1>Reserver une table</h1>
      <form method="post" acceptCharset="UTF-8">
        <fieldset>
          <fieldset>
            <h3>
              <label htmlFor="email">Email :</label>
            </h3>
            <input
              id="email"
              type="email"
              name="email"
              onChange={handleEmailInput}
              defaultValue={props.userMail}
            />
          </fieldset>

          <fieldset>
            <h3>
              <label htmlFor="number">N° de téléphone :</label>
            </h3>
            <input id="tel" type="tel" name="tel" onChange={handleNumInput} defaultValue={props.userNum} />
          </fieldset>
        </fieldset>
        <fieldset>
          <h4>
            <label htmlFor="name">Nom de la reservation :</label>
          </h4>
          <input id="name" type="text" name="name" onChange={handleNomInput} defaultValue={props.userNom}/>
        </fieldset>
        <fieldset>
          <h4>
            <label htmlFor="allergene">Allergène :</label>
          </h4>
          <textarea
            id="allergene"
            name="allergene"
            rows={5}
            cols={50}
            onChange={handleAllergeneInput}
            defaultValue={props.userAllergene}
          />
        </fieldset>
        <fieldset>
          <h4>
            <label htmlFor="commentaire">Commentaire :</label>
          </h4>
          <textarea
            id="commentaire"
            name="commentaire"
            rows={5}
            cols={50}
            onChange={handleCommentaireInput}
          />
        </fieldset>
        <p>
          Merci d’avance de préciser en commentaire le nombre d’enfants ( mois
          de 12 ans) présent à table s’il y en a , pour tout retard de plus de
          20 minutes votre table sera donnée à d’autre client! Merci de votre
          ponctualité.
        </p>
        <fieldset>
          <label htmlFor="couverts" className="icons">
            <MdRestaurant />
          </label>
          <select name="couverts" id="couverts" onChange={handleCouvertSelect} defaultValue={props.userCouvert}>
            <option value="">--Combien de couverts--</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">6</option>
            <option value="7">7</option>
          </select>
          <label htmlFor="dateResa" className="icons">
            <BsCalendar3 />
          </label>
          <input
            type="date"
            id="dateResa"
            name="dateResa"
            defaultValue={date["now"]}
            min={date["now"]}
            max={date["maxResa"]}
            onChange={(e) => testhoraire(e)}
          />
        </fieldset>
        <hr />
        <div className="HoHo">
          {HorairesMidi === "" || HorairesMidi === undefined ? null : (
            <h5>Midi</h5>
          )}
          <div className="Ho">
            {HorairesMidi === "" || HorairesMidi === undefined
              ? null
              : HorairesMidi.map((h) => (
                  <HeureResa day={h} setHeureResa={setHeureResa} />
                ))}
          </div>
          {HorairesSoir === "" || HorairesSoir === undefined ? null : (
            <h5>Soir</h5>
          )}
          <div className="Ho">
            {HorairesSoir === "" || HorairesSoir === undefined
              ? null
              : HorairesSoir.map((h) => (
                  <HeureResa
                    day={h}
                    heureResa={heureResa}
                    setHeureResa={setHeureResa}
                  />
                ))}
          </div>
        </div>
        <button className="btn_main" onClick={(e) => handleSubmit(e)}>
          Envoyer !
        </button>
      </form>
      {toast === true ? (
        <p>l'inscription c'est bien passez</p>
      ) : toast === "" ? null : (
        <p>une erreur est survenu</p>
      )}
    </Wrapper>
  );
};

const Wrapper = styled.div`
  display: flex;
  flex-direction: column;
  align-items: center;
  form fieldset {
    width: 100%;
    display: flex;
    border: none;
    align-items: start;
    justify-content: center;
  }
  form fieldset:nth-child(6) {
    align-items: normal;
  }
  form fieldset:nth-child(1) {
    justify-content: end;
  }
  form fieldset fieldset:nth-child(2) {
    justify-content: start;
  }
  form {
    display: flex;
    flex-direction: column;
    align-items: center;
  }
  form input {
    background: #b6ac97b3;
    border: none;
    padding: 5px;
  }
  form textarea {
    background: #b6ac97b3;
    border: none;
  }
  form select {
    background: #b6ac97b3;
    border: none;
  }
  form p {
    max-width: 70%;
    text-align: center;
  }
  form hr {
    width: 40%;
    border-top: 3px solid #906427;
    transform: rotate(0.57deg);
  }
  .btn_main {
    background: hsl(35, 57%, 36%, 0.5);
    border: 2px solid #392c1e;
    box-shadow: 0 1px 4px #392c1e;
    border-radius: 25px;
    align-self: end;
    margin-inline: 25%;
    margin-top: 20px;
  }
  .btn_main a {
    text-decoration: none;
    color: black;
    padding: 0 5px;
  }
  .btn_main:hover {
    box-shadow: 0 0 4px #b6ac97;
    color: #392c1e;
  }

  .btn_main:active {
    box-shadow: inset 0 0 2px 1px #392c1e;
  }
  .icons {
    border: 1px solid #392c1e;
    padding: 10px;
    background: #b6ac97b3;
    margin-left: 5px;
  }

  h3,
  h4 {
    margin-top: 0;
    margin-right: 10px;
  }
  h4 {
    width: 200px;
    text-align: right;
  }
  .Ho {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    height: content;
  }
`;
export default Reservation;
