import axios from "axios";
import React, { useState } from "react";
import styled from "styled-components";

const ModifyHoraire = (props) => {
  const [jour, setJour] = useState(props.jour);
  const [ouvert, setOuvert] = useState(props.isOpen);
  const [open_Midi, setOpen_Midi] = useState("");
  const [open_Soir, setOpen_Soir] = useState("");
  const [close_Midi, setClose_Midi] = useState("");
  const [close_Soir, setClose_Soir] = useState("");
  const [openMidi, setOpenMidi] = useState(false);
  const [openSoir, setOpenSoir] = useState(false);
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
  const handleOuvertMidiInput = (e) => {
    setOpenMidi(e.target.checked);
    setToast("");
  };
  const handleOuvertSoirInput = (e) => {
    setOpenSoir(e.target.checked);
    setToast("");
  };
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
    let formulaire = null;
    if (ouvert === false) {
      formulaire = {
        Id:props.id,
        Jour: jour,
        Ouvert: ouvert,
        OpenMidi: openMidi,
        OpenSoir: openSoir,
      };
    } else {
      if (openMidi === true && openSoir === true) {
        if (
          open_Midi >= close_Midi ||
          open_Soir >= close_Soir ||
          open_Midi === "" ||
          close_Midi === "" ||
          open_Soir === "" ||
          close_Soir === ""
        ) {
          setToast(false);
        } else {
          formulaire = {
            Id:props.id,
            Jour: jour,
            Ouvert: ouvert,
            OpenMidi: openMidi,
            OuvertureMidi: open_Midi,
            FermetureMidi: close_Midi,
            OpenSoir: openSoir,
            OuvertureSoir: open_Soir,
            FermetureSoir: close_Soir,
          };
        }
      } else {
        if (openMidi === true && openSoir === false) {
          if (open_Midi === "" || close_Midi === "") {
            setToast(false);
          } else {
            formulaire = {
              Id:props.id,
              Jour: jour,
              Ouvert: ouvert,
              OpenMidi: openMidi,
              OuvertureMidi: open_Midi,
              FermetureMidi: close_Midi,
              OpenSoir: openSoir,
            };
          }
        } else {
          if (open_Soir === "" || close_Soir === "") {
            setToast(false);
          } else {
            formulaire = {
              Id: props.id,
              Jour: jour,
              Ouvert: ouvert,
              OpenMidi: openMidi,
              OpenSoir: openSoir,
              OuvertureSoir: open_Soir,
              FermetureSoir: close_Soir,
            };
          }
        }
      }
    }
    if (formulaire === null) {
      setToast(false);
    } else {
      axios
        .post("/modifyHoraire", formulaire)
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
            <table>
              <thead>
                <tr>
                  <th>
                    <label htmlFor="Jour">Jour</label>
                  </th>
                  <th>
                    <label htmlFor="ouvert">Ouvert</label>
                  </th>
                  {ouvert === true ? (
                    <>
                      <th>
                        <label htmlFor="ouvertmidi">Midi ? </label>
                      </th>
                    </>
                  ) : null}
                  {openMidi === true ? (
                    <>
                      <th>
                        <label htmlFor="odre">Ouverture Midi </label>
                      </th>
                      <th>
                        <label htmlFor="close_midi">Fermeture Midi </label>
                      </th>
                    </>
                  ) : null}
                  <th>
                    <label htmlFor="open_soir">Soir ? </label>
                  </th>

                  {openSoir === true ? (
                    <>
                      <th>
                        <label htmlFor="open_soir">Ouverture Soir </label>
                      </th>
                      <th>
                        <label htmlFor="close_Soir">Fermeture Soir </label>
                      </th>
                    </>
                  ) : null}
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>
                    <input
                      type="text"
                      name="Jour"
                      id="Jour"
                      defaultValue={props.jour}
                      required
                      onChange={handleJourInput}
                    />
                  </td>
                  <td>
                    <input
                      type="checkbox"
                      name="ouvert"
                      id="ouvert"
                      defaultChecked={props.isOpen}
                      onChange={handleOuvertInput}
                    />
                  </td>
                  {ouvert === true ? (
                    <>
                      <td>
                        <input
                          type="checkbox"
                          name="ouvertmidi"
                          id="ouvertmidi"
                          onChange={handleOuvertMidiInput}
                        />
                      </td>
                    </>
                  ) : null}
                  {openMidi === true ? (
                    <>
                      <td>
                        <input
                          type="time"
                          name="open_midi"
                          id="open_midi"
                          onChange={handleOpenMidiInput}
                        />
                      </td>
                      <td>
                        <input
                          type="time"
                          name="close_midi"
                          id="close_midi"
                          onChange={handleCloseMidiInput}
                        />
                      </td>
                    </>
                  ) : null}
                  <td>
                    <input
                      type="checkbox"
                      name="ouvertsoir"
                      id="ouvertsoir"
                      onChange={handleOuvertSoirInput}
                    />
                  </td>
                  {openSoir === true ? (
                    <>
                      <td>
                        <input
                          type="time"
                          name="open_soir"
                          id="open_soir"
                          onChange={handleOpenSoirInput}
                        />
                      </td>
                      <td>
                        <input
                          type="time"
                          name="close_Soir"
                          id="close_Soir"
                          onChange={handleCloseSoirInput}
                        />
                      </td>
                    </>
                  ) : null}
                  <td>
                    <button type="submit" onClick={handleSubmit}>
                      Envoyer
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </form>
          {toast === "" ? null : <p>une erreur est survenu</p>}
        </div>
      ) : (
        <button onClick={handleOuvre}>Modifier</button>
      )}
    </Wrapper>
  );
};

const Wrapper = styled.div`
  position: relative;
  #actif {
    position: absolute;
    z-index: 2;
    display: flex;
    flex-direction: column;
    right: 0%;
    top: -2%;
    margin: auto;
    background: hsl(35, 57%, 36%);
    border: 2px solid black;
    .close {
      align-self: end;
      margin: 0px 10px;
    }
    form {
      display: flex;
      flex-direction: column;
      margin: 0;
    }
  }
`;

export default ModifyHoraire;
