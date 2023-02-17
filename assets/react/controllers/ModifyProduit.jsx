import axios from "axios";
import React, { useState } from "react";
import styled from "styled-components";

const ModifyProduit = (props) => {
  const [nom, setNom] = useState(props.nom);
  const [nomSousCat, setNomSousCat] = useState(props.nomSousCat);
  const [ordre, setOrdre] = useState(props.ordre);
  const [prix, setPrix] = useState(props.prix);
  const [toast, setToast] = useState("");
  const [add, setAdd] = useState(false);

  const handleNomInput = (e) => {
    setNom(e.target.value);
    setToast("");
  };
  const handleSousCatSelect = (e) => {
    setNomSousCat(e.target.value);
    setToast("");
  };
  const handlePrixInput = (e) => {
    setPrix(e.target.value);
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
      Nom: nom,
      SousCategorie: nomSousCat,
      Ordre: ordre,
      Prix: prix,
      Id: props.id,
    };
    if (ordre <= 0 || nom === "") {
      setToast(false);
    } else {
      console.log(formulaire);
      axios
        .post("/modifyProduit", formulaire)
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
                    <label htmlFor="nom">Nom :</label>
                  </th>
                  <th>
                    <label htmlFor="Prix">Prix en centimes</label>
                  </th>
                  <th>
                    <label htmlFor="categorie">SousCatégorie :</label>
                  </th>
                  <th>
                    <label htmlFor="odre">Ordre :</label>
                  </th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <tr>

                  <td data-title="Nom">
                    <input
                      type="text"
                      name="nom"
                      id="nom"
                      required
                      defaultValue={props.nom}
                      onChange={handleNomInput}
                    />
                  </td>
                  <td data-title="Prix">
                    <input
                      type="number"
                      name="Prix"
                      id="Prix"
                      defaultValue={props.prix}
                      required
                      onChange={handlePrixInput}
                    />
                  </td>
                  <td data-title="Categories">
                    <select
                      name="categories"
                      id="categories"
                      defaultValue={props.nomSousCat}
                      onChange={handleSousCatSelect}
                    >
                      {props.parents.map((parent) => (
                        <optgroup label={parent}>
                          {props.categories.map((categorie) =>
                            categorie["parent"] === parent ? (
                              <option value={categorie["nom"]}>
                                {categorie["nom"]}
                              </option>
                            ) : null
                          )}
                        </optgroup>
                      ))}
                    </select>
                  </td>
                  <td data-title="Ordre">
                    <input
                      type="number"
                      name="ordre"
                      id="ordre"
                      defaultValue={props.ordre}
                      required
                      onChange={handleOrdreInput}
                    />
                  </td>
                  <td data-title="Action">
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

export default ModifyProduit;
