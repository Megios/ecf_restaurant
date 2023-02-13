import axios from "axios";
import React, { useState } from "react";
import styled from "styled-components";

const AddHoraire = () => {
  const [jour, setJour] = useState("");
  const [ouvert, setOuvert] = useState(false);
  const [open_Midi,setOpen_Midi] = useState("");
  const [open_Soir,setOpen_Soir] = useState("");
  const [close_Midi,setClose_Midi] = useState("");
  const [close_Soir,setClose_Soir] = useState("");
  const [openMidi,setOpenMidi] = useState(false);
  const [openSoir,setOpenSoir] = useState(false);
  const [toast, setToast] = useState("");
  const [add, setAdd] = useState(false);

  const handleJourInput = (e) => {
    setJour(e.target.value);
    setToast("");
  };
  
  const handleOuvertInput = (e) => {
    setOuvert(e.target.checked);
    setToast("");
  };
  const handleOuvertMidiInput = (e) =>{
    setOpenMidi(e.target.checked);
    setToast("");
  }
  const handleOuvertSoirInput = (e) =>{
    setOpenSoir(e.target.checked);
    setToast("");
  }
  const handleOpenMidiInput = (e) => {
    setOpen_Midi(e.target.value);
    setToast("");
  };
  const handleOpenSoirInput = (e) => {
    setOpen_Soir(e.target.value);
    setToast("");
  };
  const handleCloseMidiInput = (e) => {
    setClose_Midi(e.target.value);
    setToast("");
  };
  const handleCloseSoirInput = (e) => {
    setClose_Soir(e.target.value);
    setToast("");
  };
  const handleFerme = (e) => {
    setAdd(false);
  };
  const handleOuvre = (e) => {
    setAdd(true);
  };

  const handleSubmit = (e) => {
    e.preventDefault();
    let formulaire=null;
    if(ouvert===false){
        formulaire = {
          Jour: jour,
          Ouvert: ouvert,
          OpenMidi : openMidi,
          OpenSoir: openSoir
        };
    }else{
      if(openMidi===true && openSoir===true){
        if(open_Midi>=close_Midi || open_Soir>=close_Soir || open_Midi===''||close_Midi===''|| open_Soir==='' || close_Soir===''){
          setToast(false);
        }
        else{
          formulaire = {
            Jour: jour,
            Ouvert: ouvert,
            OpenMidi : openMidi,
            OuvertureMidi:open_Midi,
            FermetureMidi:close_Midi,
            OpenSoir: openSoir,
            OuvertureSoir:open_Soir,
            FermetureSoir:close_Soir
          };
        }
      }else{
        if(openMidi===true && openSoir===false){
          if(open_Midi===''||close_Midi===''){
            setToast(false);
          }
          else{
            formulaire = {
              Jour: jour,
              Ouvert: ouvert,
              OpenMidi : openMidi,
              OuvertureMidi:open_Midi,
              FermetureMidi:close_Midi,
              OpenSoir: openSoir
            };
          }
        }else{
          if(open_Soir===''||close_Soir===''){
            setToast(false);
          }
          else{
            formulaire = {
              Jour: jour,
              Ouvert: ouvert,
              OpenMidi : openMidi,
              OpenSoir: openSoir,
              OuvertureSoir:open_Soir,
              FermetureSoir:close_Soir
            };
          }
        }
      }
    }
    if(formulaire===null){
      setToast(false)
    }
    else{
      axios
        .post("/addHoraire", formulaire)
        .then(function (response) {
          console.log(response.data.Message);
          setAdd(false);
          window.location.reload(false);
        })
        .catch(function (error) {
          console.log(error);
          setToast(false);
        });
    }
  };

  return (    
    <Wrapper>
      {add === true ? (
        <div id="actif">
          <button className="close" onClick={handleFerme}>
            X
          </button>
          <form method="post" acceptCharset="UTF-8">
            <label htmlFor="Jour">Jour :</label>
            <input
              type="text"
              name="Jour"
              id="Jour"
              required
              onChange={handleJourInput}
            />
            <label htmlFor="ouvert">Ouvert :</label>
            <input
              type="checkbox"
              name="ouvert"
              id="ouvert"
              onChange={handleOuvertInput}
            />
            {ouvert===true ?<>
              <label htmlFor="ouvertmidi">Ouvert le Midi :</label>
              <input
                type="checkbox"
                name="ouvertmidi"
                id="ouvertmidi"
                onChange={handleOuvertMidiInput}
              />
              {openMidi===true?<>
                <label htmlFor="odre">Ouverture Midi :</label>
                <input
                  type="time"
                  name="open_midi"
                  id="open_midi"
                  onChange={handleOpenMidiInput}
                />
                <label htmlFor="close_midi">Fermeture Midi :</label>
                <input
                  type="time"
                  name="ouvclose_midi"
                  id="close_midi"
                  onChange={handleCloseMidiInput}
                />
              </>:null}
              <label htmlFor="ouvertsoir">Ouvert le Soir :</label>
              <input
                type="checkbox"
                name="ouvertsoir"
                id="ouvertsoir"
                onChange={handleOuvertSoirInput}
              />
              {openSoir===true?<>
                
                <label htmlFor="open_soir">Ouverture Soir :</label>
                <input
                  type="time"
                  name="open_soir"
                  id="open_soir"
                  onChange={handleOpenSoirInput}
                />
                <label htmlFor="close_Soir">Fermeture Soir :</label>
                <input
                  type="time"
                  name="close_Soir"
                  id="close_Soir"
                  onChange={handleCloseSoirInput}
                />
                </>:null}
              </>
              :null}
            <button type="submit" onClick={handleSubmit}>
              Envoyer
            </button>
          </form>
          {toast === "" ? null : <p>une erreur est survenu</p>}
        </div>
      ) : <button className="btn_main " onClick={handleOuvre}>Ajouter une Carte</button>}
    </Wrapper>
  );
};

const Wrapper = styled.div`
  #actif {
    display: flex;
    flex-direction: column;
    top: 20vh;
    margin: auto;
    background: white;
    border: 2px solid black;
    .close {
      align-self: end;
      margin:5px 10px;
    }
    form{
      display: flex;
    flex-direction: column;
    margin: 10px;
    }
  }
`;

export default AddHoraire;