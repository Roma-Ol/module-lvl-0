<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* modules/custom/romaroma/templates/guestbook.html.twig */
class __TwigTemplate_5c100df63c482cff408541399b44111f1314d7652da2c474e084b1fff00239ef extends \Twig\Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
        $this->sandbox = $this->env->getExtension('\Twig\Extension\SandboxExtension');
        $this->checkSecurity();
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->extensions['Drupal\Core\Template\TwigExtension']->attachLibrary("romaroma/romaroma-style"), "html", null, true);
        echo "
<div class=\"guestbook-page-wrapper\">
    <div class=\"form-wrapper-first\">
        <div class=\"form-wrapper-second\">
            ";
        // line 5
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["form"] ?? null), 5, $this->source), "html", null, true);
        echo "
        </div>
    </div>

    <div class=\"table-wrapper-first\">
        <div class=\"table-wrapper-second\">
            <p class=\"table-header\">List of the guests</p>
            ";
        // line 12
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["content"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["i"]) {
            // line 13
            echo "                <div class=\"db-table-content\">
                    <div class=\"profile-author-info-block\">
                        <div class=\"profile-pic\">
                            ";
            // line 16
            if (twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["i"], "profilePic", [], "any", false, false, true, 16), "data", [], "any", false, false, true, 16)) {
                // line 17
                echo "                                <a data-fslightbox=\"gallery\" href=\"";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["i"], "profilePic", [], "any", false, false, true, 17), "url", [], "any", false, false, true, 17), 17, $this->source), "html", null, true);
                echo "\">
                                    <img src=\"";
                // line 18
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["i"], "profilePic", [], "any", false, false, true, 18), "url", [], "any", false, false, true, 18), 18, $this->source), "html", null, true);
                echo "\" alt=\"img\">
                                </a>
                            ";
            } else {
                // line 21
                echo "                                    <img src=\"/modules/custom/romaroma/media/defaultImage.jpg\" alt=\"xz\">
                            ";
            }
            // line 23
            echo "                        </div>
                        <div class=\"profile-info\">
                            <div class=\"profile-user-name profile-info-row\">
                                ";
            // line 26
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Name: "));
            echo "

                                ";
            // line 28
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["i"], "name", [], "any", false, false, true, 28), 28, $this->source), "html", null, true);
            echo "
                            </div>
                            <div class=\"profile-user-email profile-info-row\">
                                ";
            // line 31
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Mail: "));
            echo "

                                <a href=\"mailto:";
            // line 33
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["i"], "mail", [], "any", false, false, true, 33), 33, $this->source), "html", null, true);
            echo "\">";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["i"], "mail", [], "any", false, false, true, 33), 33, $this->source), "html", null, true);
            echo "</a>
                            </div>
                            <div class=\"profile-user-phone-number profile-info-row\">
                                ";
            // line 36
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Tel: "));
            echo "

                                <a href=\"tel:";
            // line 38
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["i"], "phone", [], "any", false, false, true, 38), 38, $this->source), "html", null, true);
            echo "\">";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["i"], "phone", [], "any", false, false, true, 38), 38, $this->source), "html", null, true);
            echo "</a>
                            </div>

                            <div class=\"administerButtons\">
                                ";
            // line 42
            if (twig_get_attribute($this->env, $this->source, ($context["user"] ?? null), "hasPermission", [0 => "administer nodes"], "method", false, false, true, 42)) {
                // line 43
                echo "                                    <div class=\"interact-buttons\">
                                        <div class=\"button-wrapper-div\">
                                            <a href='/romaroma/EditGuest/";
                // line 45
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["i"], "id", [], "any", false, false, true, 45), 45, $this->source), "html", null, true);
                echo "' class=\"db-table-button db-table-button-edit use-ajax\" data-dialog-type=\"modal\">Edit this guest</a>
                                        </div>
                                        <div class=\"button-wrapper-div\">
                                            <a href='/romaroma/deleteGuest/";
                // line 48
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["i"], "id", [], "any", false, false, true, 48), 48, $this->source), "html", null, true);
                echo "' class=\"db-table-button db-table-button-delete use-ajax\" data-dialog-type=\"modal\">Delete this guest</a>
                                        </div>
                                    </div>
                                ";
            }
            // line 52
            echo "                            </div>
                        </div>
                    </div>
                    <div class=\"profile-feedback-block\">
                        <div class=\"feedback-content\">
                            <div class=\"feedback-text\">
                                ";
            // line 58
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["i"], "feedback", [], "any", false, false, true, 58), 58, $this->source), "html", null, true);
            echo "
                            </div>
                            <div class=\"feedbackPic\">
                                ";
            // line 61
            if (twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["i"], "feedbackPic", [], "any", false, false, true, 61), "data", [], "any", false, false, true, 61)) {
                // line 62
                echo "                                    <a data-fslightbox=\"gallery\" href=\"";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["i"], "feedbackPic", [], "any", false, false, true, 62), "url", [], "any", false, false, true, 62), 62, $this->source), "html", null, true);
                echo "\">
                                        <img src=\"";
                // line 63
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["i"], "feedbackPic", [], "any", false, false, true, 63), "url", [], "any", false, false, true, 63), 63, $this->source), "html", null, true);
                echo "\" alt=\"img\">
                                    </a>
                                ";
            }
            // line 66
            echo "                            </div>
                            <div class=\"feedback-date-wrapper\">
                                <div class=\"feedback-date\">
                                    ";
            // line 69
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Publication date: "));
            echo " ";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["i"], "created", [], "any", false, false, true, 69), 69, $this->source), "html", null, true);
            echo "
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['i'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 77
        echo "        </div>
    </div>
</div>";
    }

    public function getTemplateName()
    {
        return "modules/custom/romaroma/templates/guestbook.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  192 => 77,  176 => 69,  171 => 66,  165 => 63,  160 => 62,  158 => 61,  152 => 58,  144 => 52,  137 => 48,  131 => 45,  127 => 43,  125 => 42,  116 => 38,  111 => 36,  103 => 33,  98 => 31,  92 => 28,  87 => 26,  82 => 23,  78 => 21,  72 => 18,  67 => 17,  65 => 16,  60 => 13,  56 => 12,  46 => 5,  39 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "modules/custom/romaroma/templates/guestbook.html.twig", "/var/www/web/modules/custom/romaroma/templates/guestbook.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("for" => 12, "if" => 16);
        static $filters = array("escape" => 1, "trans" => 26);
        static $functions = array("attach_library" => 1);

        try {
            $this->sandbox->checkSecurity(
                ['for', 'if'],
                ['escape', 'trans'],
                ['attach_library']
            );
        } catch (SecurityError $e) {
            $e->setSourceContext($this->source);

            if ($e instanceof SecurityNotAllowedTagError && isset($tags[$e->getTagName()])) {
                $e->setTemplateLine($tags[$e->getTagName()]);
            } elseif ($e instanceof SecurityNotAllowedFilterError && isset($filters[$e->getFilterName()])) {
                $e->setTemplateLine($filters[$e->getFilterName()]);
            } elseif ($e instanceof SecurityNotAllowedFunctionError && isset($functions[$e->getFunctionName()])) {
                $e->setTemplateLine($functions[$e->getFunctionName()]);
            }

            throw $e;
        }

    }
}
