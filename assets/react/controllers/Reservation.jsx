import React, { useState } from "react";
import styled from "styled-components";
import { MdRestaurant } from "react-icons/md";
import { BsCalendar3 } from "react-icons/bs";
import HeureResa from "./HeureResa";

const Reservation = (props) => {
  const date = props.date;
  const jours = {
    1: "lundi",
    2: "mardi",
    3: "mercredi",
    4: "jeudi",
    5: "vendredi",
    6: "samedi",
    0: "dimanche",
  };

  //useStateInit
  const [emailResa, setEmailResa] = useState("");
  const [numResa, setNumResa] = useState("");
  const [nomResa, setNomResa] = useState("");
  const [allergeneResa, setAllergeneResa] = useState("");
  const [commentaireResa, setCommentaireResa] = useState("");
  const [couvertsResa, setCouvertsResa] = useState("");
  const [dateResa, setDateResa] = useState("");
  const [heureResa, setHeureResa] = useState("");
  const [jour, setJour] = useState("");
  const [HorairesMidi, setHorairesMidi] = useState();
  const [HorairesSoir, setHorairesSoir] = useState();

  let testhoraire = (e) => {
    const test = new Date(e.target.value);
    console.log(jours[test.getDay()]);
    setDateResa(test);
    setJour(test.getDay());
    setHorairesMidi(["12:00", "12:15", "12:30", "12:45", "13:00"]);
    setHorairesSoir([
      "17:00",
      "17:15",
      "17:30",
      "17:45",
      "18:00",
      "18:15",
      "18:30",
      "18:45",
      "19:00",
    ]);
  };

  //handle
  const handleSubmit = (e) => {
    e.preventDefault();
    let formulaire = {
      Email: emailResa,
      Num: numResa,
      Nom: nomResa,
      Allergene: allergeneResa,
      Commentaire: commentaireResa,
      Couverts: couvertsResa,
      Dates: dateResa,
      Heure: heureResa,
    };
    console.log(formulaire);
  };

  const handleEmailInput = (e) => setEmailResa(e.target.value);
  const handleNumInput = (e) => setNumResa(e.target.value);
  const handleNomInput = (e) => setNomResa(e.target.value);
  const handleAllergeneInput = (e) => setAllergeneResa(e.target.value);
  const handleCommentaireInput = (e) => setCommentaireResa(e.target.value);
  const handleCouvertSelect = (e) => setCouvertsResa(e.target.value);
  let lundi = {
    open: true,
    open_midi: "12:00",
    close_midi: "14:00",
    open_soir: "17:00",
    close_soir: "22:00",
  };

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
            />
          </fieldset>

          <fieldset>
            <h3>
              <label htmlFor="number">N° de téléphone :</label>
            </h3>
            <input id="tel" type="tel" name="tel" onChange={handleNumInput} />
          </fieldset>
        </fieldset>
        <fieldset>
          <h4>
            <label htmlFor="name">Nom de la reservation :</label>
          </h4>
          <input id="name" type="text" name="name" onChange={handleNomInput} />
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
          <select name="couverts" id="couverts" onChange={handleCouvertSelect}>
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
