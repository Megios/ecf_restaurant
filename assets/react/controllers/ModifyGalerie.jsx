import axios from "axios";
import React, { useState } from "react";
import styled from "styled-components";

const ModifyMenu = (props) => {
  const [titre, setTitre] = useState(props.titre);
  const [ordre, setOrdre] = useState(props.ordre);
  const [format,setFormat] = useState(props.format);
  const [toast, setToast] = useState("");
  const [add, setAdd] = useState(false);

  const handleTitreInput = (e) => {
    setTitre(e.target.value);
    setToast("");
  };
  const handleFormatInput = (e) => {
    setFormat(e.target.value);
    setToast("");
  };
  const handleOrdreInput = (e) => {
    setOrdre(e.target.value);
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
    let formulaire = {
      Titre: titre,
      Format: format,
      Ordre: ordre,
      Uuid: props.uuid,
    };
    if (
      ordre <= 0 ||
      titre === "" ||
      format === "" 
    ) {
      setToast(false);
    } else {
      axios
        .post("/modifyGalerie", formulaire)
        .then(function (response) {
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
                    <label htmlFor="titre">Titre</label>
                  </th>
                  <th>
                    <label htmlFor="description">Format</label>
                  </th>
                  <th>
                    <label htmlFor="odre">Ordre</label>
                  </th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>

                <tr>
                  <td>
                    <input
                      type="text"
                      name="titre"
                      id="titre"
                      defaultValue={props.titre}
                      required
                      onChange={handleTitreInput}
                    />
                  </td>
                  <td>
                    <select id="format" name="format" onChange={handleFormatInput} defaultValue={props.format}>
                      <option value="paysage">paysage</option>
                      <option value="portrait">portrait</option>
                    </select>
                  </td>
                  <td>
                    <input
                      type="number"
                      name="ordre"
                      id="ordre"
                      required
                      defaultValue={props.ordre}
                      onChange={handleOrdreInput}
                    />
                  </td>
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
        <button onClick={handleOuvre}>
          Modifier
        </button>
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
export default ModifyMenu;
